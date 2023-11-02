#ifndef __CTRL_H_
#define __CTRL_H_

typedef enum 
{
	APP_NO_ERROR = 0,
	APP_NOT_ENOUTH_ARGS,
	APP_TOO_MUCH_ARGS,
	APP_FILE_OPEN_ERROR,
	APP_ALLOC_ERROR,
	APP_READ_ERROR,
} app_error;

typedef struct
{
	const char *inputFile;
} app_args;

app_error app_get_args(app_args *pArgs, int argc, const char *argv[]);
app_error app_read_all(char **pBuffer, const char *filename);
app_error app_simulation_init(char *buffer);

#endif