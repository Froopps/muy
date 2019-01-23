fr_file=open("friends_query.sql","w",encoding="utf-8")

s='@gmail.com'
query="INSERT INTO amicizia VALUES("
l=[chr(i)+s for i in range(97,123)]
for i in range(len(l)//2):
    fr_file.write(query+'\''+l[i]+'\'\''+l[len(l)-i-1]+'\',NULL,NULL)\n')
fr_file.close()

