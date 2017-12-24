from itertools import *
def AG(x = 679):
    while True: x = x * 16807 % 2147483647; yield x
def BG(x = 771):
    while True: x = x * 48271 % 2147483647; yield x
# part 1
print sum(imap(
    lambda (a, b): a & 0xFFFF == b & 0xFFFF,
    islice(izip(AG(), BG()), 40000000)))
# part 2
print sum(imap(
    lambda (a, b): a & 0xFFFF == b & 0xFFFF,
    islice(izip(
        ifilter(lambda x: x % 4 == 0, AG()),
        ifilter(lambda x: x % 8 == 0, BG())), 5000000)))

