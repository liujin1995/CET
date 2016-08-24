#!/usr/bin/env python
# coding=utf-8
import sys
from CetTicket import CetTicket
import json
        
if __name__ == '__main__':
    ct = CetTicket()
    if len(sys.argv) == 4:
        province = sys.argv[1].decode('utf8')
        school = sys.argv[2].decode('utf8')
        name = sys.argv[3].decode('utf8')
        ticket = ct.find_ticket_number(province, school, name, cet_type=CetTicket.CET6)
        result = ct.get_score(ticket, name)
        result['ticket'] = ticket
    elif len(sys.argv) == 3:
        ticket = sys.argv[1].decode('utf8')
        name = sys.argv[2].decode('utf8')
        result = ct.get_score(ticket, name)
        result['ticket'] = ticket
    print json.dumps(result)