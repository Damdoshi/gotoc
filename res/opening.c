
#include <lapin.h>
#include <stdlib.h>
#include <stdio.h>

void *__callstack[128];
size_t __cstop = 0;

#ifdef GFX_MODE

t_bunny_window *__window;
t_bunny_pixelarray *__pix;

void display()
{
  bunny_blit(&__window->buffer, &__pix->clipable, NULL);
  bunny_display(__window);
}

void out()
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
      atexit(out);
      __pix = bunny_new___pixelarray(__window->buffer.width, __window->buffer.height);
    }
}

void clear()
{
  if (__window)
    memset(__pix->__pixels, 0, __pix->clipable.buffer.width * __pix->clipable.buffer.height * 4);
}

void text_mode()
{
  if (!__window)
    return ;
  bunny_stop(__window);
  __window = NULL;
}

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

int main(int argc, char **argv)
{


