# CAPSTONE Project program - Network Building Tool
# Author: Benjamin C. Lorentson
# This program will take input data on any IPv4 network build topology, and calculate subnetting and IP schema information

def main():

    running = True
    validation = True
    exceed = False

    #IPclean takes in an IPv4 address (as a list) and coverts any octet over 255 by increasing the prior octet, so 192.168.0.256 becomes 192.168.1.0, and 192.256.0.512 becomes 193.0.2.0; it returns the list with the converted values
    def IPclean(addr,exceed):
        if addr[3] > 255:
            iterations = int(addr[3] / 256)
            addr[3] -= iterations * 256
            addr[2] += iterations
        if addr[2] > 255:
            iterations2 = int(addr[2] / 256)
            addr[2] -= iterations2 * 256
            addr[1] += iterations2
        if addr[1] > 255:
            iterations3 = int(addr[1] / 256)
            addr[1] -= iterations3 * 256
            addr[0] += iterations3
        if addr[0] > 255:
            if exceed == False:
                print("WARNING: INVALID IPv4 ADDRESS.  IPv4 addresses cannot exceed 255.255.255.255.\nThe tool will continue subnetting, but all addresses from this point forward are invalid and unusable in a real-world scenario.")
                print()
                exceed = True
        return addr,exceed

    #IPreadable effectively 'un-splits' the list used to contain IPv4 addresses, converting it into the standard readable format for printing purposes
    def IPreadable(addr):
        read1 = str(addr[0])
        read2 = str(addr[1])
        read3 = str(addr[2])
        read4 = str(addr[3])
        readable = read1 + "." + read2 + "." + read3 + "." + read4
        return readable
        
        
            
            

    #Walkthrough Mode - Will give the user detailed explanations of data to enter and what the program is doing at each step, and explain the process of subnetting an IPv4 network build along the way
    def walkthrough():
        print("\n" * 5)
        print("====== Beginning Walktrhough Mode ======")
        print("\n" * 5)
        print("------ WALKTHROUGH MODE: STEP 1")
        print("\n")
        print('Let’s get started!  First, we’ll collect some data from your network build.')
        print()
        print('First, we need to know how many separate subnetworks are in the build.')
        print('Every separate COLLISION DOMAIN is a separate subnetwork, so you’ll need to count the')
        print('number of collision domains.  To find this, look for routers on the network build; each separate')
        print('connection coming from a router is a separate collision domain.  This includes one for every')
        print('direct (point-to-point) connection between two routers.  However, connections between switches')
        print('and hosts are all part of a single subnetwork.  You only need to count the connections that go')
        print('from a router to another device.')
        #Get subnet count
        print()
        print("<INPUT>")
        print()
        subnetCount = input("No. of Subnets (enter an integer): ")
        subnetInt = int(subnetCount)
        if subnetInt < 1:
            print("WARNING: Subnet Count is less than 1.  No subnet information will be generated - use only for tutorial purposes.")
            print()
        print()
        print("\n" * 5)
        print("------ WALKTHROUGH MODE: STEP 2")
        print("\n")
        print('Secondly, we need to determine the size of each subnet.  While we’re at it, let’s go ahead and')
        print('name each subnet to make things easier to read. Your network build might show groups of')
        print('hosts as a computer or laptop icon, with a name like “ACCOUNTING” or “SALES” and a number')
        print('of hosts.  Go ahead and input the name and number of hosts for each subnet, starting with the')
        print('largest number of hosts and moving down from there.  For your last subnet(s), if there are any')
        print('point-to-point connections between routers, name each one uniquely so that you will')
        print('remember which is which, and input the number of hosts as 2.')
        #Get names and host counts for each subnet
        print()
        print("<INPUT>")
        print()
        subnetNames = []
        for i in range (0, subnetInt):
            j = i+1
            counter = str(j)
            name = input("Name for subnet #" + counter + ": ")
            subnetNames.append(name)
        subnets = []
        for i in range (0, subnetInt):
            validation = True
            while validation:
                hosts = input("Number of hosts in the " + subnetNames[i] + " subnet (type a number): ")
                if hosts.isnumeric() == False:
                    print("ERROR: Number of hosts must be an integer value and cannot be negative.  Please enter a valid number of hosts.")
                    print()
                    continue
                else:
                    validation = False
                hostInt = int(hosts)
                subnets.append(hostInt)
        print("\n" * 5)
        print("------ WALKTHROUGH MODE: STEP 3")
        print("\n")
        print('Third, let’s determine the starting address.  This is the address that we can begin subnetting')
        print('from, and should be provided with your network build.  In a business scenario, this would')
        print('represent the first address that is not already being used somewhere else in the business.  If')
        print('there is no address provided, or if you are just building on your own, it is recommended you use')
        print('the standard Class C private address range, starting at 192.168.0.0.')
        print()
        print('NOTE: Type the IP address carefully; make sure the numbers are right, and that each octet is')
        print('separated by a “.” just like in the address above.  Otherwise, the program may misread it.')
        print()
        print("<INPUT>")
        print()
        #get starting IP address
        validation = True
        while validation:
            startAddress = input("Starting IP address: ")
            address = startAddress.split(".")
            if len(address) != 4:
                print("ERROR: IP address must be four positive numerals with periods separating them.  Please enter a valid IP address.")
                print()
                continue
            elif address[0].isnumeric() == False or address[1].isnumeric() == False or address[2].isnumeric() == False or address[3].isnumeric() == False:
                print("ERROR: IP address must be four positive numerals with periods separating them.  Please enter a valid IP address.")
                print()
                continue
            else:
                validation = False
            map_object = map(int, address)
            listAddress = list(map_object)
            if listAddress[0] > 255 or listAddress[1] > 255 or listAddress[2] > 255 or listAddress[3] > 255:
                print("ERROR: IP address must consist of four octets with values between 0 and 255.  Please enter a valid IP address.")
                print()
                continue
            else:
                validation = False
        print("\n" * 5)
        print("------ WALKTHROUGH MODE: STEP 4")
        print("\n")
        print('Now that we have the data needed, let’s start subnetting!  First, let’s determine the IP Address')
        print('Class you’re using, and whether it’s a private or public address.  For Private addresses, the tool')
        print('will also tell you if it’s one of the standard private IP ranges (RFC1918), if it is an Automatic')
        print('Private IP Address (APIPA), or if it is in the loopback address block (localhost).  You might not')
        print('need all this information for every build, but it’s always good to know what you’re working with…')
        print()
        print("<OUTPUT>")
        print()
        #Calculate data for output
        
        exceed = False
        listAddress,exceed = IPclean(listAddress,exceed)
        #Determine address class
        if listAddress[0] >= 0 and listAddress[0] <= 127:
            addressClass = 'A'
        elif listAddress[0] >= 128 and listAddress[0] <= 191:
            addressClass = 'B'
        elif listAddress[0] >= 192 and listAddress[0] <= 223:
            addressClass = 'C'
        elif listAddress[0] >= 224 and listAddress[0] <= 239:
            addressClass = 'D'
        elif listAddress[0] >= 240 and listAddress[0] <= 255:
            addressClass = 'E'
        else:
            print("WARNING: You are using an invalid IPv4 address.  Valid IPv4 addresses must have a value between 0 and 255 in EVERY octet.")
            print("If you wish to start again with a valid IPv4 address, restart the Network Building Tool.  If you wish to continue, the tool will proceed using the invalid address.")
            print()
            addressClass = 'Invalid'

        #Check if address is private (Localhost, APIPA, or one of the standard RFC 1918 private IP ranges) or public
        if listAddress[0] == 10:
            privacy = "Private (RFC 1918)"
        elif listAddress[0] == 127:
            privacy = "Private (Localhost)"
        elif listAddress[0] == 169 and listAddress[1] == 254:
            privacy = "Private (APIPA)"
        elif listAddress[0] == 172 and listAddress[1] >= 16 and listAddress[1] <= 31:
            privacy = "Prviate (RFC 1918)"
        elif listAddress[0] == 192 and listAddress[1] == 168:
            privacy = "Private (RFC 1918)"
        elif addressClass == 'Invalid':
            privacy = "Public (INVALID)"
        else:
            privacy = "Public"

        print("Starting IP address: ", end =" ")
        print(IPreadable(listAddress))
        print("Address Class: " + addressClass)
        print("This is a " + privacy + " IP Address")
        print()
        pause = input("Press enter to continue...")
        
        print("\n" * 5)
        print("------ WALKTHROUGH MODE: STEP 5")
        print("\n")
        print('Next we’ll calculate the info you need for each subnet.  The key to subnetting is using the')
        print('Classless Inter-Domain Routing (CIDR) table.  Each subnet will have a CIDR notation, like “/24”')
        print('or “/30”, which corresponds to the size of the subnet.  Each CIDR notation corresponds to a')
        print('certain number of available addresses, as well as a certain subnet mask.')
        print()
        print('This is the key information you need for subnetting.  You’ll need each subnet’s Network Address')
        print('(NA), First Available Address (FA), Last Available Address (LA), and Broadcast Address (BA). ')
        print('You’ll also need the aforementioned Subnet Mask (SM).')
        print()
        print('The tool will determine, based on the number of hosts you provided, which CIDR notation is')
        print('used for each subnet.  This tells it the subnet mask, and how many addresses will be allocated')
        print('to the subnet, allowing it to calculate the NA, FA, LA, and BA, as follows…')
        print()
        print('The NA is the very first address of the subnet.  The FA is the next address after the NA.  The LA')
        print('is equal to the NA + the number of hosts that CIDR notation supports.  The BA is the next')
        print('address after the LA.  Then, the following address is the NA of the next subnet.')
        print()
        print()
        print('Here is the subnetting information for each of the subnets you inputted.  The wildcard mask is')
        print('also displayed; this is essentially the inverse of the subnet mask.  You may need this for some')
        print('network builds, but you can ignore it for the basic subnetting part.')
        print()
        print('Remember, those /30 subnets that have only two hosts are most likely your point-to-point')
        print('connections that directly connect two routers.  The first available address should be one router,')
        print('and the last available is the other router.')
        print()
        print("<OUTPUT>")
        print()
        
        #Loop to display subnetting information for each host group
        for x in range(0, subnetInt):
            y = x+1
            counter = str(y)
            hostCount = str(subnets[x])

            #determine CIDR, and set the increase value, subnet mask, and wildcard mask based on that cidr notation
            if subnets[x] <= 2:
                cidr = '30'
                increase = 1
                netmask = "255.255.255.252"
                wildcard = "0.0.0.3"
            elif subnets[x] <= 6:
                cidr = '29'
                increase = 5
                netmask = "255.255.255.248"
                wildcard = "0.0.0.7"
            elif subnets[x] <= 14:
                cidr = '28'
                increase = 13
                netmask = "255.255.255.240"
                wildcard = "0.0.0.15"
            elif subnets[x] <= 30:
                cidr = '27'
                increase = 29
                netmask = "255.255.255.224"
                wildcard = "0.0.0.31"
            elif subnets[x] <= 62:
                cidr = '26'
                increase = 61
                netmask = "255.255.255.192"
                wildcard = "0.0.0.63"
            elif subnets[x] <= 126:
                cidr = '25'
                increase = 125
                netmask = "255.255.255.128"
                wildcard = "0.0.0.127"
            elif subnets[x] <= 254:
                cidr = '24'
                increase = 253
                netmask = "255.255.255.0"
                wildcard = "0.0.0.255"
            elif subnets[x] <= 510:
                cidr = '23'
                increase = 509
                netmask = "255.255.254.0"
                wildcard = "0.0.1.255"
            elif subnets[x] <= 1022:
                cidr = '22'
                increase = 1021
                netmask = "255.255.252.0"
                wildcard = "0.0.3.255"
            elif subnets[x] <= 2046:
                cidr = '21'
                increase = 2045
                netmask = "255.255.248.0"
                wildcard = "0.0.7.255"
            elif subnets[x] <= 4094:
                cidr = '20'
                increase = 4093
                netmask = "255.255.240.0"
                wildcard = "0.0.15.255"
            elif subnets[x] <= 8190:
                cidr = '19'
                increase = 8189
                netmask = "255.255.224.0"
                wildcard = "0.0.31.255"
            elif subnets[x] <= 16382:
                cidr = '18'
                increase = 16381
                netmask = "255.255.192.0"
                wildcard = "0.0.63.255"
            elif subnets[x] <= 32766:
                cidr = '17'
                increase = 32765
                netmask = "255.255.128.0"
                wildcard = "0.0.127.255"
            elif subnets[x] <= 65534:
                cidr = '16'
                increase = 65533
                netmask = "255.255.0.0"
                wildcard = "0.0.255.255"
            elif subnets[x] <= 131070:
                cidr = '15'
                increase = 131070
                netmask = "255.254.0.0"
                wildcard = "0.1.255.255"
            elif subnets[x] <= 262142:
                cidr = '14'
                increase = 262141
                netmask = "255.252.0.0"
                wildcard = "0.3.255.255"
            elif subnets[x] <= 524286:
                cidr = '13'
                increase = 524285
                netmask = "255.248.0.0"
                wildcard = "0.7.255.255"
            elif subnets[x] <= 1048574:
                cidr = '12'
                increase = 1048573
                netmask = "255.240.0.0"
                wildcard = "0.15.255.255"
            elif subnets[x] <= 2097150:
                cidr = '11'
                increase = 2097149
                netmask = "255.224.0.0"
                wildcard = "0.31.255.255"
            elif subnets[x] <= 4194302:
                cidr = '10'
                increase = 4194301
                netmask = "255.192.0.0"
                wildcard = "0.63.255.255"
            elif subnets[x] <= 8388606:
                cidr = '9'
                increase = 8388605
                netmask = "255.128.0.0"
                wildcard = "0.127.255.255"
            elif subnets[x] <= 16777214:
                cidr = '8'
                increase = 16777213
                netmask = "255.0.0.0"
                wildcard = "0.255.255.255"
            elif subnets[x] <= 33554430:
                cidr = '7'
                increase = 33554429
                netmask = "254.0.0.0"
                wildcard = "1.255.255.255"
            elif subnets[x] <= 67108862:
                cidr = '6'
                increase = 67108861
                netmask = "252.0.0.0"
                wildcard = "3.255.255.255"
            elif subnets[x] <= 134217726:
                cidr = '5'
                increase = 134217725
                netmask = "248.0.0.0"
                wildcard = "7.255.255.255"
            elif subnets[x] <= 268435454:
                cidr = '4'
                increase = 268435453
                netmask = "240.0.0.0"
                wildcard = "15.255.255.255"
            elif subnets[x] <= 536870910:
                cidr = '3'
                increase = 536870909
                netmask = "224.0.0.0"
                wildcard = "31.255.255.255"
            elif subnets[x] <= 1073741822:
                cidr = '2'
                increase = 1073741821
                netmask = "192.0.0.0"
                wildcard = "63.255.255.255"
            elif subnets[x] <= 2147483646:
                cidr = '1'
                increase = 2147483645
                netmask = "128.0.0.0"
                wildcard = "127.255.255.255"
            elif subnets[x] <= 4294967294:
                cidr = '0'
                increase = 4294967293
                netmask = "0.0.0.0"
                wildcard = "255.255.255.255"
            else:
                cidr = 'Error'
                print("WARNING: The number of hosts in this subnet is invalid.  The tool will proceed as if there were 0 hosts in this subnet.")
                print()
                increase = 0
                netmask = "Invalid"
                wildcard = "Invalid"

            
            print(subnetNames[x] + " Subnet (" + hostCount + " hosts)...")
            print()
            print("CIDR Notation = /" + cidr)
            print()
            print("Subnet Mask: " + netmask)
            print()
            print("Wildcard Mask: " + wildcard)
            print()
            print()
            print("Network Address: ", end=" ")
            print(IPreadable(listAddress))
            listAddress[3] += 1
            listAddress,exceed = IPclean(listAddress,exceed)
            print("First Available Address: ", end=" ")
            print(IPreadable(listAddress))
            listAddress[3] += increase
            listAddress,exceed = IPclean(listAddress,exceed)
            print("Last Available Address: ", end=" ")
            print(IPreadable(listAddress))
            listAddress[3] += 1
            listAddress,exceed = IPclean(listAddress,exceed)
            print("Broadcast Address: ", end=" ")
            print(IPreadable(listAddress))
            print()
            print()
            listAddress[3] += 1
            listAddress,exceed = IPclean(listAddress,exceed)
            
        print("\n" * 5)
        pause = input("All done!  Press enter to bring up the main menu again (this output will not be cleared)...")
        print()
            

    #Quickstart Mode - Will take in the basic information of a network build and provide a quick and simple ouput page, for automated subnetting or error checking
    def quickstart():
        print("\n" * 5)
        print("====== Beginning Quick Start Mode ======")
        print("\n" * 5)
        print("------ QUICK START MODE: INPUT DATA")
        print()
        

        #Get number of subnets and the hosts needed for each one, and validate
        print()
        print('Enter the following data.  Be careful to type IP addresses correctly, and type a period "." between each octet (ex. "192.168.0.0" or "10.0.0.0")')
        print()
        subnetCount = input("No. of Subnets (enter an integer): ")
        subnetInt = int(subnetCount)
        if subnetInt < 1:
            print("WARNING: Subnet Count is less than 1.  No subnet information will be generated - use only to check IP address classes.")
            print()
        subnets = []
        for i in range (0, subnetInt):
            j = i+1
            counter = str(j)
            validation = True
            while validation:
                hosts = input("No. of hosts in subnet " + counter + " (enter an integer): ")
                if hosts.isnumeric() == False:
                    print("ERROR: Number of hosts must be an integer value and cannot be negative.  Please enter a valid number of hosts.")
                    print()
                    continue
                else:
                    validation = False
                hostInt = int(hosts)
                subnets.append(hostInt)
        print()

        #get starting IP address and validate
        validation = True
        while validation:
            startAddress = input("Starting IP address: ")
            address = startAddress.split(".")
            if len(address) != 4:
                print("ERROR: IP address must be four positive numerals with periods separating them.  Please enter a valid IP address.")
                print()
                continue
            elif address[0].isnumeric() == False or address[1].isnumeric() == False or address[2].isnumeric() == False or address[3].isnumeric() == False:
                print("ERROR: IP address must be four positive numerals with periods separating them.  Please enter a valid IP address.")
                print()
                continue
            else:
                validation = False
            map_object = map(int, address)
            listAddress = list(map_object)
            if listAddress[0] > 255 or listAddress[1] > 255 or listAddress[2] > 255 or listAddress[3] > 255:
                print("ERROR: IP address must consist of four octets with values between 0 and 255.  Please enter a valid IP address.")
                print()
                continue
            else:
                validation = False
        #address = exploded string of startAddress with four fields, one for each octet
        #map_object and listAddress used to map and create a list of integer values, so that numeric operations can be performed on each octet and values over 255 can be converted
        print("\n" * 5)
        print("------ QUICK START MODE: OUTPUT")
        print()
        print("Here's a summary of your network build...")
        print()
        #Use IPclean function to convert numbers over 255 into proper IPv4 address format; pass and return the 'exceed' Boolean so that the warning message only triggers once
        exceed = False
        listAddress,exceed = IPclean(listAddress,exceed)
        #Determine address class
        if listAddress[0] >= 0 and listAddress[0] <= 127:
            addressClass = 'A'
        elif listAddress[0] >= 128 and listAddress[0] <= 191:
            addressClass = 'B'
        elif listAddress[0] >= 192 and listAddress[0] <= 223:
            addressClass = 'C'
        elif listAddress[0] >= 224 and listAddress[0] <= 239:
            addressClass = 'D'
        elif listAddress[0] >= 240 and listAddress[0] <= 255:
            addressClass = 'E'
        else:
            print("WARNING: You are using an invalid IPv4 address.  Valid IPv4 addresses must have a value between 0 and 255 in EVERY octet.")
            print("If you wish to start again with a valid IPv4 address, restart the Network Building Tool.  If you wish to continue, the tool will proceed using the invalid address.")
            print()
            addressClass = 'Invalid'

        #Check if address is private (Localhost, APIPA, or one of the standard RFC 1918 private IP ranges) or public
        if listAddress[0] == 10:
            privacy = "Private (RFC 1918)"
        elif listAddress[0] == 127:
            privacy = "Private (Localhost)"
        elif listAddress[0] == 169 and listAddress[1] == 254:
            privacy = "Private (APIPA)"
        elif listAddress[0] == 172 and listAddress[1] >= 16 and listAddress[1] <= 31:
            privacy = "Prviate (RFC 1918)"
        elif listAddress[0] == 192 and listAddress[1] == 168:
            privacy = "Private (RFC 1918)"
        elif addressClass == 'Invalid':
            privacy = "Public (INVALID)"
        else:
            privacy = "Public"


        
            
        print("Starting IP address: ", end =" ")
        print(IPreadable(listAddress))
        print("Address Class: " + addressClass)
        print("This is a " + privacy + " IP Address")
        print()
        print()


        #Loop to display subnetting information for each host group
        for x in range(0, subnetInt):
            y = x+1
            counter = str(y)
            hostCount = str(subnets[x])

            #determine CIDR, and set the increase value, subnet mask, and wildcard mask based on that cidr notation
            if subnets[x] <= 2:
                cidr = '30'
                increase = 1
                netmask = "255.255.255.252"
                wildcard = "0.0.0.3"
            elif subnets[x] <= 6:
                cidr = '29'
                increase = 5
                netmask = "255.255.255.248"
                wildcard = "0.0.0.7"
            elif subnets[x] <= 14:
                cidr = '28'
                increase = 13
                netmask = "255.255.255.240"
                wildcard = "0.0.0.15"
            elif subnets[x] <= 30:
                cidr = '27'
                increase = 29
                netmask = "255.255.255.224"
                wildcard = "0.0.0.31"
            elif subnets[x] <= 62:
                cidr = '26'
                increase = 61
                netmask = "255.255.255.192"
                wildcard = "0.0.0.63"
            elif subnets[x] <= 126:
                cidr = '25'
                increase = 125
                netmask = "255.255.255.128"
                wildcard = "0.0.0.127"
            elif subnets[x] <= 254:
                cidr = '24'
                increase = 253
                netmask = "255.255.255.0"
                wildcard = "0.0.0.255"
            elif subnets[x] <= 510:
                cidr = '23'
                increase = 509
                netmask = "255.255.254.0"
                wildcard = "0.0.1.255"
            elif subnets[x] <= 1022:
                cidr = '22'
                increase = 1021
                netmask = "255.255.252.0"
                wildcard = "0.0.3.255"
            elif subnets[x] <= 2046:
                cidr = '21'
                increase = 2045
                netmask = "255.255.248.0"
                wildcard = "0.0.7.255"
            elif subnets[x] <= 4094:
                cidr = '20'
                increase = 4093
                netmask = "255.255.240.0"
                wildcard = "0.0.15.255"
            elif subnets[x] <= 8190:
                cidr = '19'
                increase = 8189
                netmask = "255.255.224.0"
                wildcard = "0.0.31.255"
            elif subnets[x] <= 16382:
                cidr = '18'
                increase = 16381
                netmask = "255.255.192.0"
                wildcard = "0.0.63.255"
            elif subnets[x] <= 32766:
                cidr = '17'
                increase = 32765
                netmask = "255.255.128.0"
                wildcard = "0.0.127.255"
            elif subnets[x] <= 65534:
                cidr = '16'
                increase = 65533
                netmask = "255.255.0.0"
                wildcard = "0.0.255.255"
            elif subnets[x] <= 131070:
                cidr = '15'
                increase = 131070
                netmask = "255.254.0.0"
                wildcard = "0.1.255.255"
            elif subnets[x] <= 262142:
                cidr = '14'
                increase = 262141
                netmask = "255.252.0.0"
                wildcard = "0.3.255.255"
            elif subnets[x] <= 524286:
                cidr = '13'
                increase = 524285
                netmask = "255.248.0.0"
                wildcard = "0.7.255.255"
            elif subnets[x] <= 1048574:
                cidr = '12'
                increase = 1048573
                netmask = "255.240.0.0"
                wildcard = "0.15.255.255"
            elif subnets[x] <= 2097150:
                cidr = '11'
                increase = 2097149
                netmask = "255.224.0.0"
                wildcard = "0.31.255.255"
            elif subnets[x] <= 4194302:
                cidr = '10'
                increase = 4194301
                netmask = "255.192.0.0"
                wildcard = "0.63.255.255"
            elif subnets[x] <= 8388606:
                cidr = '9'
                increase = 8388605
                netmask = "255.128.0.0"
                wildcard = "0.127.255.255"
            elif subnets[x] <= 16777214:
                cidr = '8'
                increase = 16777213
                netmask = "255.0.0.0"
                wildcard = "0.255.255.255"
            elif subnets[x] <= 33554430:
                cidr = '7'
                increase = 33554429
                netmask = "254.0.0.0"
                wildcard = "1.255.255.255"
            elif subnets[x] <= 67108862:
                cidr = '6'
                increase = 67108861
                netmask = "252.0.0.0"
                wildcard = "3.255.255.255"
            elif subnets[x] <= 134217726:
                cidr = '5'
                increase = 134217725
                netmask = "248.0.0.0"
                wildcard = "7.255.255.255"
            elif subnets[x] <= 268435454:
                cidr = '4'
                increase = 268435453
                netmask = "240.0.0.0"
                wildcard = "15.255.255.255"
            elif subnets[x] <= 536870910:
                cidr = '3'
                increase = 536870909
                netmask = "224.0.0.0"
                wildcard = "31.255.255.255"
            elif subnets[x] <= 1073741822:
                cidr = '2'
                increase = 1073741821
                netmask = "192.0.0.0"
                wildcard = "63.255.255.255"
            elif subnets[x] <= 2147483646:
                cidr = '1'
                increase = 2147483645
                netmask = "128.0.0.0"
                wildcard = "127.255.255.255"
            elif subnets[x] <= 4294967294:
                cidr = '0'
                increase = 4294967293
                netmask = "0.0.0.0"
                wildcard = "255.255.255.255"
            else:
                cidr = 'Error'
                print("WARNING: The number of hosts in this subnet is invalid.  The tool will proceed as if there were 0 hosts in this subnet.")
                print()
                increase = 0
                netmask = "Invalid"
                wildcard = "Invalid"

            
            print("Subnet #" + counter + "(" + hostCount + " hosts)...")
            print()
            print("CIDR Notation = /" + cidr)
            print()
            print("Subnet Mask: " + netmask)
            print()
            print("Wildcard Mask: " + wildcard)
            print()
            print()
            print("Network Address: ", end=" ")
            print(IPreadable(listAddress))
            listAddress[3] += 1
            listAddress,exceed = IPclean(listAddress,exceed)
            print("First Available Address: ", end=" ")
            print(IPreadable(listAddress))
            listAddress[3] += increase
            listAddress,exceed = IPclean(listAddress,exceed)
            print("Last Available Address: ", end=" ")
            print(IPreadable(listAddress))
            listAddress[3] += 1
            listAddress,exceed = IPclean(listAddress,exceed)
            print("Broadcast Address: ", end=" ")
            print(IPreadable(listAddress))
            print()
            print()
            listAddress[3] += 1
            listAddress,exceed = IPclean(listAddress,exceed)

        print("\n" * 5)
        pause = input("All done!  Press enter to bring up the main menu again (this output will not be cleared)...")
        print()
            
        # Loop: For each value of Subnets[x], print the CIDR notation, netmask and wildcard.  Then increase the listAddress and print the Network Address, First Available, Last Available, and Broadcast Address
        # CIDR is calculated first to determine the increase variable (increase is 1 less than that CIDR's maximum # of hosts, so a /25 would be 125
        # 1st NA is start address, FA is NA +1, LA is FA + increase by CIDR (max hosts - 1), BA = FA +1; then the next NA for the next Subnet is the last BA+1
        # After each increase, run the address array through a function that will ask if any number is over 255, and if it is, subtract 256 [NOT 255] and add 1 to the prior field
        
    
    print()
    print("====== Welcome to the Network Building Tool! ======")
    while running:
        print()
        print("1. Begin in Walkthrough Mode")
        print("2. Begin in Quick Start Mode")
        print("3. Exit the Program")
        
        menuChoice = input("Please select an option: ")
        
        if menuChoice == '1':
            walkthrough()

        elif menuChoice == '2':
            quickstart()

        elif menuChoice == '3':
            running = False

        else:
            print()
            print("Please enter a valid selection... ")

main()
