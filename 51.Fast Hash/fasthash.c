#include <stdio.h>
#include <stdlib.h>
#include <stddef.h>
#include <string.h>
#include <unistd.h>
#include <sys/time.h>
#include <sys/syscall.h>
#include <sys/mman.h>

typedef struct user_t {
	char *name;
	char *password;
	struct user_t *next;
} User;

static User *users;

__attribute__ ((noreturn)) static void safe_exit(int status)
{
	syscall(SYS_exit_group, status);
}

static void write_str(const char *s)
{
	size_t l = strlen(s);
	if (write(1, s, l) != l)
		safe_exit(1);
}

static int get_line(char *buf, int size)
{
	int i;
	char c;
	for (i = 0; i < size-1; i++) {
		if (read(0, &c, 1) != 1)
			safe_exit(1);
		if (c == '\n')
			break;
		buf[i] = c;
	}
	buf[i] = '\0';
	return i;
}

static int get_int()
{
	char buf[32];
	if (get_line(buf, sizeof(buf)) == 0)
		safe_exit(1);
	return atoi(buf);
}

static void do_hash()
{
	int nlen;
	char buf[64];
	int hash = 0;
	write_str("input > ");
	nlen = get_line(buf, sizeof(buf));
	for (int i = 0; i < nlen; i++) {
		hash += buf[i];
	}
	write_str("hash: ");
	write_str((char*) &hash);
	write_str("\n");
}

static void remove_user(User *user)
{
	if (users == user) {
		users = user->next;
	}
	else {
		for (User *ptr = users; ptr != NULL; ptr = ptr->next) {
			if (ptr->next == user) {
				ptr->next = user->next;
				break;
			}
		}
	}
	
	free(user->name);
	memset(user->password, 0, strlen(user->password));
	free(user->password);
	free(user);
}

static void change_pwd(User *login_user)
{
	int nlen;
	char buf[32];
	write_str("new pwd > ");
	nlen = get_line(buf, sizeof(buf));
	if (nlen == 0 || nlen > strlen(login_user->password)) {
		write_str("Invalid password\n");
		remove_user(login_user);
	}
	else {
		strcpy(login_user->password, buf);
	}
}

static void service(User *login_user)
{
	int sel;
	do {
		write_str("Menu\n"
			"1) Calculate Hash\n"
			"2) Change password\n"
			"3) Remove me\n"
			"0) Log out\n"
			"Cmd > "
			);
		sel = get_int();
		switch (sel) {
			case 1:
				do_hash();
				break;
			case 2:
				change_pwd(login_user);
				break;
			case 3:
				remove_user(login_user);
				sel = 0;
				break;
		}
	} while (sel);
}

static User *get_user(const char *user)
{
	for (User *ptr = users; ptr != NULL; ptr = ptr->next) {
		if (strcmp(user, ptr->name) == 0) {
			return ptr;
		}
	}
	return NULL;
}

static User *register_user()
{
	char buf[32];
	int nlen;
	User *user = NULL;
	
	write_str("name > ");
	nlen = get_line(buf, sizeof(buf));
	if (nlen > 0 && get_user(buf) == NULL) {
		user = (User*) malloc(sizeof(User));
		user->name = strdup(buf);

		write_str("pwd > ");
		nlen = get_line(buf, sizeof(buf));
		user->password = strdup(buf);
		
		user->next = users;
		users = user;
	}
	
	return user;
}

static User *auth_user(const char *user, const char *pwd)
{
	User *u = get_user(user);
	if (u != NULL && strcmp(pwd, u->password) != 0)
		u = NULL;
	return u;
}

static void login()
{
	char username[32];
	char password[32];
	User *login_user;
	
	write_str("name > ");
	get_line(username, sizeof(username));
	write_str("pwd > ");
	get_line(password, sizeof(password));
	login_user = auth_user(username, password);
	if (login_user)
		service(login_user);
}

static void list_users()
{
	for (User *ptr = users; ptr != NULL; ptr = ptr->next) {
		write_str("- ");
		write_str(ptr->name);
		write_str("\n");
	}
}

extern void *(*__morecore)(ptrdiff_t); // internal glibc malloc pointer for request system memory

static void * my_morecore(ptrdiff_t size)
{
	static void *addr;
	if (addr == NULL) {
		struct timeval tv;
		unsigned long hi, lo;
		__asm__ ("rdtsc" : "=a"(lo), "=d"(hi));
		gettimeofday(&tv, NULL);
		addr = (void*) (((hi ^ lo ^ tv.tv_sec ^ tv.tv_usec ^ getpid()) & 0xfffffff) << 12);
		addr = mmap((void*) addr, 0x1000, PROT_READ|PROT_WRITE, MAP_PRIVATE|MAP_ANONYMOUS|MAP_FIXED, 0, 0);
		if (addr == (void*) -1)
			return NULL;
	}

	if (size == 0)
		return ((char*) addr) + 0x1000;
	return addr;
}

static void init(char *envp)
{
	// custom heap location
	__morecore = my_morecore;

	unsigned long *ptr = (unsigned long *) malloc(0xee0);
	if (ptr == NULL)
		safe_exit(0);
	ptr[-1] = 0;

	__morecore = NULL; // prevent expanding heap memory

	// close all _IO_FILE
	fclose(stderr);
	dup2(0, 2);
	fclose(stdin);
	dup2(2, 0);
	dup2(1, 2);
	fclose(stdout);
	dup2(2, 1);
	close(2);
	
	alarm(60);
	for (int i = 0; i < 16; i++)
		envp[i] = i;
}

int main(int argc, char **argv, char **envp)
{
	init((char*) envp);
	
	write_str("Welcome\n");
		
	while (1) {
		write_str("Menu\n"
			"1) Sign Up\n"
			"2) Login\n"
			"3) List\n"
			"0) Quit\n"
			"Cmd > "
			);
		switch (get_int()) {
			case 1:
				register_user();
				break;
			case 2:
				login();
				break;
			case 3:
				list_users();
				break;
			case 0:
				safe_exit(0);
		}
	}
	
	return 0;
}
