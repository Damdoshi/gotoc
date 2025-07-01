
#include <stdlib.h>
#include <stdio.h>
#include <math.h>
#include <stdbool.h>
#include <unistd.h>
#include <sys/ioctl.h>

void *__callstack[128];
size_t __cstop = 0;

static void __move(int x, int y)
{
  char buffer[128];
  int len;

  len = snprintf(buffer, sizeof(buffer), "\e[%d;%d;H", y, x * 2);
  write(1, buffer, len);
}

static void __save_cpos()
{
  write(1, "\e[s", 3);
}

static void __restore_cpos()
{
  write(1, "\e[u", 3);
}

#if 0

static void __color(bool back, int r, int g, int b)
{
  char buffer[128];
  int len;
  int bk;

  if (back)
    bk = 48;
  else
    bk = 38;
  len = snprintf(buffer, sizeof(buffer), "\e[%d;2;%d;%d;%dm", bk, r, g, b);
  write(1, buffer, len);
}

#else

static int __colorc(int r, int g, int b)
{
  if (r == g && g == b)
    {
      if (r < 8)
	return 16;
      if (r > 248)
	return 231;
      return 232 + (int)((r - 8) / 247.0 * 24);
    }

  int r6 = (int)(r / 255.0 * 5 + 0.5);
  int g6 = (int)(g / 255.0 * 5 + 0.5);
  int b6 = (int)(b / 255.0 * 5 + 0.5);
  
  return 16 + 36 * r6 + 6 * g6 + b6;
}

static void __color(bool back, int r, int g, int b)
{
  char buffer[128];
  int len;
  int bk;

  if (back)
    bk = 48;
  else
    bk = 38;
  len = snprintf(buffer, sizeof(buffer), "\e[%d;5;%dm", bk, __colorc(r, g, b));
  write(1, buffer, len);
}

#endif

bool __shell_get_terminal_size(int *x, int *y)
{
  struct winsize	wsiz;
  // Récupération de la taille du terminal
  if (ioctl(1, TIOCGWINSZ, &wsiz) != 0)
    {
      *x = 80;
      *y = 40;
      return (false);
    }
  *x = wsiz.ws_col;
  *y = wsiz.ws_row;
  return (true);
}

#ifdef GFX_MODE
# include <lapin.h>

t_bunny_window *__window;
t_bunny_pixelarray *__pix;

void display()
{
  bunny_blit(&__window->buffer, &__pix->clipable, NULL);
  bunny_display(__window);
}

static void __out()
{
  if (__window)
    bunny_stop(__window);
}

void gfx_mode()
{
  if (__window)
    return ;
  __window = bunny_start(1920, 1080, false, "GOTOC");
  if (!__pix)
    {
      atexit(__out);
      __pix = bunny_new___pixelarray(__window->buffer.width, __window->buffer.height);
    }
}

void clear()
{
  if (__window)
    memset(__pix->__pixels, 0, __pix->clipable.buffer.width * __pix->clipable.buffer.height * 4);
  else
    ;
}

void text_mode()
{
  if (!__window)
    return ;
  bunny_stop(__window);
  __window = NULL;
}

int width()
{
  int x, y;
  
  if (__window)
    return (__pix->clipable.buffer.width);
  __shell_get_terminal_size(&x, &y);
  return (x);
}

int height()
{
  int x, y;

  if (__window)
    return (__pix->clipable.buffer.height);
  __shell_get_terminal_size(&x, &y);
  return (y);
}

# else

void clear()
{
  write(1, "\e[2J", 4);
}

void letter(int x, int y, char c, int color, int backcolor)
{
  __move(x, y);
  __color(false, color & 255,
	  (color >> 8) & 255,
	  (color >> 16) & 255
	  );
  __color(true, backcolor & 255,
	  (backcolor >> 8) & 255,
	  (backcolor >> 16) & 255
	  );
  write(1, &c, 1);
}

void plot(int x, int y, int color)
{
  __move(x, y);
  __color(true, color & 255,
	  (color >> 8) & 255,
	  (color >> 16) & 255
	  );
  write(1, "  ", 2);
}

int width()
{
  int x, y;
  
  __shell_get_terminal_size(&x, &y);
  return (x);
}

int height()
{
  int x, y;

  __shell_get_terminal_size(&x, &y);
  return (y);
}

void text_mode()
{}

#endif

#define if(a) if (a) {
#define endif }
#define fi endif

#ifndef ONLY_GOTO
# define while(a) while (a) {
# define endwhile }
# define wend endwhile

# define for(a) for (a) {
# define endfor }
# define next endfor
# define fend endfor

# define done }

# define do do {
# define enddo(a) } while (a)
# define dend(a) enddo(a)
#endif

#define call(f) __callstack[__cstop++] = && l ## __AFTER; goto l ## f;
#define back goto *__callstack[--__cstop];

int main(int argc, char **argv, char **env)
{


