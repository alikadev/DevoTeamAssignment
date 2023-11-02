#include <stdio.h>
#include <stdlib.h>
#include <assert.h>

#include "app.h"

app_error app_get_args(
	app_args *pArgs, 
	int argc, 
	const char *argv[])
{
	// Assertions for arguments
	assert(pArgs && "In app_get_args argument pArgs is NULL");
	assert(argc && "In app_get_args argument argc is 0");
	assert(argv && "In app_get_args argument argv is NULL");

	// Check argument
	if (argc < 2) return APP_NOT_ENOUTH_ARGS;
	if (argc > 2) return APP_TOO_MUCH_ARGS;

	// Get the argument
	pArgs->inputFile = argv[1];

	return APP_NO_ERROR;
}

app_error app_read_all(
	char **pBuffer,
	const char *filename)
{
	FILE *file;
	size_t fileSize;
	
	// Open the file
	file = fopen(filename, "r");
	if (!file) return APP_FILE_OPEN_ERROR;

	// Get the file size
	fseek(file, 0, SEEK_END);
	fileSize = ftell(file);
	rewind(file);

	// Allocate enouth memory for the file
	*pBuffer = malloc(fileSize + 1);

	if (!*pBuffer) 
	{
		fclose(file);
		return APP_ALLOC_ERROR;
	}
	
	// Read the whole file into the pBuffer
	(*pBuffer)[fileSize] = 0;
	fread(*pBuffer, fileSize, 1, file);

	if (ferror(file))
	{
		free(*pBuffer);
		fclose(file);
		return APP_READ_ERROR;
	}

	// Close everything
	fclose(file);

	return APP_NO_ERROR;
}