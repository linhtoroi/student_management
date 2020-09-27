#include <GL/glut.h>

void init(){
	glClearColor(0.5,0.7, 0.5, 0.0);
	gluOrtho2D(0,800,0,450);	
}

void display()
{
glClear(GL_COLOR_BUFFER_BIT); 
glColor3f(1,0,0);
glBegin(GL_POLYGON);
	glVertex2f(100,300);
	glVertex2f(100,100);
	glVertex2f(200,100);
	glVertex2f(200,300);
glEnd(); 
glFlush();
glutSwapBuffers();
}
int main(int argc, char** argv)
{
glutInit(&argc, argv);
glutInitDisplayMode(GLUT_DOUBLE | GLUT_RGBA);
glutInitWindowSize(800,640);
glutInitWindowPosition(100,100);
glutCreateWindow("OpenGL");
init();
glutDisplayFunc(display);
//gluOrtho2D(0,640,0,640);
//glClearColor(0.5,0.7,0.5,0);
glutMainLoop();
return 0;
}
