#include "app.h"

void robot_do_right(robot_t *robot)
{
	switch (robot->direction)
	{
	case NORTH:
		robot->direction = EAST;
		return;
	case EAST:
		robot->direction = SOUTH;
		return;
	case SOUTH:
		robot->direction = WEST;
		return;
	case WEST:
		robot->direction = NORTH;
		return;
	}
}

void robot_do_left(robot_t *robot)
{
	switch (robot->direction)
	{
	case NORTH:
		robot->direction = WEST;
		return;
	case EAST:
		robot->direction = NORTH;
		return;
	case SOUTH:
		robot->direction = EAST;
		return;
	case WEST:
		robot->direction = SOUTH;
		return;
	}
}

void robot_do_forward(robot_t *robot, const world_t *world)
{
	/*
	Int casts are needed to compare the values in signed coordinates
	 */
	switch (robot->direction)
	{
	case NORTH:
		if ((int)robot->y - 1 > 0)
			robot->y--;
		return;

	case EAST:
		if (robot->x + 1 < world->width)
			robot->x++;
		return;

	case SOUTH:
		if (robot->y + 1 < world->height)
			robot->y++;
		return;

	case WEST:
		if ((int)robot->x - 1 > 0)
			robot->x--;
		return;
	}
}
