#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <time.h>

static char* load_key()
{
	char *mem;
	
	// load key to 'mem' which is randomly allocated
	
	return mem;
}

int main(int argc, char* argv[])
{
	struct timespec tp;
	struct timespec usertp;
	long diff;
	
	clock_gettime(CLOCK_MONOTONIC, &tp);
	
	usertp.tv_sec = strtoul(argv[1], NULL, 16);
	usertp.tv_nsec = strtoul(argv[2], NULL, 16);
	
	diff = tp.tv_sec - usertp.tv_sec;
	if (diff != 0 && diff != 1)
		return 0;
	diff = (diff*1000000000) + tp.tv_nsec - usertp.tv_nsec;
	if (diff > 1000000) // 1ms
		return 0;

	// ... 
		
	char input[32];
	printf("key is at %p\n", load_key());
	printf("give me address to leak info: ");
	fflush(stdout);
	read(0, input, sizeof(input));
	unsigned long addr = strtoul(input, NULL, 10);
	write(1, (void*) addr, 64);
	
	return 0;
}
