#/bin/sh

# Enregistrer un nouvel admin dans la base de donnees

salt='@|-°+==04601doQ' ;

if [ "$#" -ne 2 ]; then
    echo "Usage register.sh [pseudo] [password]" ;
else
    conc=$salt$1$salt$2$salt ;
    echo "USE tsumarion ; INSERT INTO admin VALUES (NULL,'$1',MD5('$conc')) ;" | mysql -u root -proot ;
fi



