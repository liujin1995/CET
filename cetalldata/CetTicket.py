#!/usr/bin/env python
# coding=utf-8
import os
import ctypes
import random
import CetConfig
import daili
from ctypes import CDLL, c_char, c_int, byref, create_string_buffer, Structure, Union

try:
    import requests
except ImportError:
    print('You need to install requests to use full functions.')


def get_random_ip():
    return '.'.join(['%d' % random.randint(1, 254) for i in xrange(4)])


def random_mac():
    return '-'.join(['%.2X' % random.randint(0, 16) for i in xrange(6)])


DES_cblock = c_char * 8
DES_LONG = c_int


class TicketNotFound(Exception):
    pass


class ks(Union):
    _fields_ = [
        ('cblock', DES_cblock),
        ('deslong', DES_LONG * 2)
    ]


class DES_key_schedule(Structure):
    _fields_ = [
        ('ks', ks * 16),
    ]


class CetCipher(object):
    """
        ticket_number_key = '(YesuNRY'
        request_data_key = '?!btwNP^'
        ticket_number_key = '021yO6d<'
        request_data_key = 'PgidW;O;'
    """
    ticket_number_key = '021yO6d<'
    request_data_key = 'PgidW;O;'

    DECRYPT = 0
    ENCRYPT = 1

    def __init__(self, libcrypto_path=None):
        if not libcrypto_path:
            from ctypes.util import find_library
            libcrypto_path = find_library('crypto')
            if not libcrypto_path:
                raise Exception('libcrypto(OpenSSL) not found')

        self.libcrypto = CDLL(libcrypto_path)

        if hasattr(self.libcrypto, 'OpenSSL_add_all_ciphers'):
            self.libcrypto.OpenSSL_add_all_ciphers()

    def process_data(self, indata, key, is_enc=1):
        length = len(indata)

        indata = create_string_buffer(indata, length)
        outdata = create_string_buffer(length)
        n = c_int(0)
        key = DES_cblock(*tuple(key))
        key_schedule = DES_key_schedule()

        self.libcrypto.DES_set_odd_parity(key)
        self.libcrypto.DES_set_key_checked(byref(key), byref(key_schedule))

        self.libcrypto.DES_cfb64_encrypt(byref(indata),
                                         byref(outdata),
                                         c_int(length),
                                         byref(key_schedule), byref(key), byref(n), c_int(is_enc))

        return outdata.raw

    def decrypt_ticket_number(self, ciphertext):
        ciphertext = ciphertext[2:]
        return self.process_data(ciphertext, self.ticket_number_key, is_enc=self.DECRYPT)

    def encrypt_request_data(self, request_data):
        return self.process_data(request_data, self.request_data_key, is_enc=self.ENCRYPT)


class CetTicket(object):

    """
        usage:
        ct = CetTicket()
        print ct.find_ticket_number('浙江', '浙江海洋学院', 'XXX', cet_type=2)
    """

    search_url = 'http://find.cet.99sushe.com/search'
    score_url = 'https://cet.99sushe.com/getscore'

    CET4 = 1
    CET6 = 2

    USER_AGENT = os.environ.get('USER_AGENT', '高坂穗乃果')

    @classmethod
    def find_ticket_number(cls, province, school, name, examroom='', cet_type=1):
        """
            You can read the `school.json` file to check if your school is supported.
            cet_type:
                    1 ==> cet4
                    2 ==> cet6
        """
        cipher = CetCipher()

        province_id = CetConfig.PROVINCE[province]
        param_data = u'type=%d&provice=%d&school=%s&name=%s&examroom=%s&m=%s' % (cet_type, province_id,
                                                                                                school, name, 
                                                                                                examroom, random_mac())
        param_data = param_data.encode('gbk')
        encrypted_data = cipher.encrypt_request_data(param_data)

        resp = requests.post(url=cls.search_url, data=encrypted_data,headers={'User-Agent':cls.USER_AGENT,'Content-Length':len(encrypted_data)},proxies=daili.proxies)

        ticket_number = cipher.decrypt_ticket_number(resp.content)
        if ticket_number == '':
            raise TicketNotFound('Cannot find ticket number.')

        return ticket_number

    @classmethod
    def get_score(cls, ticket_number, name):
        name = name.encode('gbk')

        params_dict = {
            'id': ticket_number,
            'name': name[:4]
        }
	
        resp = requests.post(url=cls.score_url+ticket_number,
                             data=params_dict,
                             headers={'Referer': 'https://cet.99sushe.com/','X-Forwarded-For':get_random_ip(),'cookie':'id='+ticket_number,'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.106 Safari/537.36'},verify=False)
        score_data = resp.content.decode('gbk')
        if len(score_data) < 10:
            return dict(error=True)
        score_data = score_data.split(',')

        score = {
            'name': score_data[6],
            'school': score_data[5],
            'listening': score_data[1],
            'reading': score_data[2],
            'writing': score_data[3],
            'total': score_data[4]
        }
        return score

if __name__ == '__main__':
        ct = CetTicket()
	print(ct.find_ticket_number(u'50', u'重庆xx大学', u'张三', cet_type=CetTicket.CET4))
	"""
		print(ct.get_score(u'508070112345678',u'张三'))
	"""
