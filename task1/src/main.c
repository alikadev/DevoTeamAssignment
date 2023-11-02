#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <errno.h>

#include "app.h"

extern int errno;

int main(int argc, char const *argv[])
{
	app_error error;
	app_args args;
	char *buffer = 0;


	// === Get the arguments === //
	error = app_get_args(&args, argc, argv);

	if (error == APP_NOT_ENOUTH_ARGS
		|| error == APP_TOO_MUCH_ARGS) 
	{
		printf("Usage: %s inputFile\n", *argv);
		exit(0);
	}

	if (error != APP_NO_ERROR)
	{
		fprintf(stderr, "Unexpected error (0x%X)\n", error);
		goto exit_failure;
	}


	// === Read the file === //
	error = app_read_all(&buffer, args.inputFile);

	if (error == APP_FILE_OPEN_ERROR)
	{
		printf("Fail to open the file '%s': %s\n", args.inputFile, strerror(errno));
		goto exit_failure;
	}

	if (error == APP_ALLOC_ERROR)
	{
		printf("Fail allocate memory: %s\n", strerror(errno));
		goto exit_failure;
	}

	if (error == APP_READ_ERROR)
	{
		printf("Fail read the file '%s': %s\n", args.inputFile, strerror(errno));
		goto exit_failure;
	}


	printf("File content:\n%s\n", buffer);


	// === The End === //
	free(buffer);
	return 0;

	// This part of the code free all the possibly 
	// allocated bytes and exit as failure.
	exit_failure:
	if (buffer)
		free(buffer);
	return 1;
}