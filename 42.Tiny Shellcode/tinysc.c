#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include <sys/mman.h>


int main(){
	void* leet;
	leet = mmap(0x31337000, 0x1000, 
		    PROT_READ | PROT_WRITE | PROT_EXEC,
		    MAP_PRIVATE | MAP_ANONYMOUS, 0,0);

	char *ptr = leet+0x1000-6;
	gets(ptr);
	strncpy(leet,ptr,5);
	(*(void (*)())leet)();
}
