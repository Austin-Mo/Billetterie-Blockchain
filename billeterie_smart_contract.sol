// SPDX-License-Identifier: GPL-3.0
pragma solidity >=0.7.0 <0.9.10;

contract ListAddress {

    event NewAddress(uint taille, address address_billet);

    address[] private addresses;

    function addAddress(address address_billet) public {
        addresses.push(address_billet);
        emit NewAddress(addresses.length, address_billet);
    }

    function removeAddress(address address_billet) public {
        for (uint i=0; i<addresses.length; i++) {
            if (addresses[i] == address_billet) {
                for (uint j = i; j < addresses.length - 1; j++) {
                    addresses[j] = addresses[j+1];
                }
                addresses.pop();
                break;
            }
        }
    }

    // function that returns entire adresses
    function getAddresses() public view returns (address[] memory) {
        return addresses;
    }
}