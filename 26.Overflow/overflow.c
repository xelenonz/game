#include <stdio.h>
#include <string.h>
#include <stdlib.h>

void secret(){
        FILE *fp = fopen("/game/overflow.key","r");
        char letter;  
        while( ( letter = fgetc(fp) ) != EOF )
                printf("%c",letter);
        fclose(fp);
}

int main(){
        char name[50];
        int priv = 0;
        puts("Pwn me if you can!!\n");
                fgets(name,52, stdin);
        if (priv){
                puts("w00t w00t\n");
                secret();
        }
        else
                puts("such a n00b lolololol\n");
                
 }
