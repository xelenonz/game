// Note: 'getkey' binary path is /game/getkey
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <sys/mman.h>
#include <seccomp.h>
#include <sys/prctl.h>

#define MAP_SIZE	0x1000

static void sandbox()
{
	if (prctl(PR_SET_NO_NEW_PRIVS, 1, 0, 0, 0) == -1) {
		//printf("set no new privs failed\\n");
		exit(0);
	}
	
	scmp_filter_ctx ctx = seccomp_init(SCMP_ACT_ALLOW);
	if (ctx == NULL) {
		//printf("seccomp error\\n");
		exit(0);
	}

	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(socket), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(listen), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(connect), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(dup), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(dup2), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(dup3), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(execve), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(execveat), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(name_to_handle_at), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(open_by_handle_at), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(mmap), 0);
	seccomp_rule_add(ctx, SCMP_ACT_KILL, SCMP_SYS(mprotect), 0);

	if (seccomp_load(ctx) < 0) {
		seccomp_release(ctx);
		//printf("seccomp error\n");
		exit(0);
	}
	seccomp_release(ctx);
}

static void recv_data(char *buffer)
{
	unsigned int len = 0;
	int rlen;
	rlen = read(0, &len, sizeof(len));
	if (rlen != sizeof(len) || len > MAP_SIZE)
		exit(0);
	
	while (len > 0) {
		rlen = read(0, buffer, len);
		if (rlen <= 0)
			exit(0);
		buffer += rlen;
		len -= rlen;
	}
	
	close(0);
	close(1);
	close(2);
}

int main(int argc, char* argv[])
{
	void* sc = mmap(NULL, MAP_SIZE, PROT_WRITE|PROT_READ, MAP_ANONYMOUS|MAP_PRIVATE, -1, 0);
	recv_data(sc);
	mprotect(sc, MAP_SIZE, PROT_READ|PROT_EXEC);
	
	sandbox();
	
	(*(void(*)()) sc)();

	return 0;
}
