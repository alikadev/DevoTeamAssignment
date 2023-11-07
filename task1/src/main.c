#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <ctype.h>
#include <errno.h>

#include "app.h"

extern int errno;

extern robot_t robot;

int main(int argc, char const *argv[])
{
	app_status status;
	app_args args;
	char *buffer = NULL;
	char *start = NULL;


	// === Get the arguments === //
	status = app_get_args(&args, argc, argv);

	if (status == APP_NOT_ENOUTH_ARGS
		|| status == APP_TOO_MUCH_ARGS) 
	{
		printf("Usage: %s inputFile\n", *argv);
		exit(0);
	}

	if (status != APP_SUCCESS)
	{
		fprintf(stderr, "Unexpected error (0x%X)\n", status);
		goto exit_failure;
	}

	debugf("Input file: %s\n", args.inputFile);

	// === Read the file === //
	status = app_read_all(&buffer, args.inputFile);
	start = buffer;

	if (status == APP_FILE_OPEN_ERROR)
	{
		fprintf(stderr, "Fail to open the file '%s': %s\n", 
				args.inputFile, strerror(errno));
		goto exit_failure;
	}

	if (status == APP_ALLOC_ERROR)
	{
		fprintf(stderr, "Fail allocate memory: %s\n", 
				strerror(errno));
		goto exit_failure;
	}

	if (status == APP_READ_ERROR)
	{
		fprintf(stderr, "Fail read the file '%s': %s\n", 
				args.inputFile, strerror(errno));
		goto exit_failure;
	}

	// === Prepare the world === // 
	status = app_simulation_init(&buffer);
	if (status == APP_BAD_FILE_FORMAT)
	{
		fprintf(stderr, "Bad file format...\n");
		goto exit_failure;
	}

	status = app_simulate(buffer);
	if (status == APP_BAD_INSTRUCTION)
	{
		fprintf(stderr, "Bad instruction\n");
		goto exit_failure;
	}

	printf("Report: %ld %ld %c\n", robot.x, robot.y, robot.direction);

	// === The End === //
	free(start);
	return 0;

	// This part of the code free all the possibly 
	// allocated bytes and exit as failure.
	exit_failure:
	if (start)
		free(start);
	return 1;
}
