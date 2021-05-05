Instruction to run this project
-------------------------------------

## For backend

@ Download and install composer from https://getcomposer.org/
@ Open CMD and type composer to check its installed correctly
@ Download and install xampp/wampp https://www.apachefriends.org/index.html or https://www.wampserver.com/en/
@ If you have downloade xampp then put the project in htdocs directory or www directory for wamp
@ Make sure your php version is >=7.2
@ Go to the folder directory "backend" open CMD within the location and run composer update
@ Look it's downloading some packages and libraries and storing in the vendor directory of the backend project.
  Wait till download is fully completed.
@ Open xampp/wampp throw web browser create a database according to your need.
@ There is a exist file name demo.sql in the backend root directory you can import it from your database or you can create new tables in the database using command "php artisan migrate" from backend root directory using cmd.

@ Change the FRONTEND_URL from .env according to your frontend domain name


## For Forntend

@ Download node and install from https://nodejs.org/en/
@ Open CMD and type node to check its installed correctly
@ Make sure node version is up to >= v14.15.3
@ Go the directory of the frontend project
@ Open CMD in the frontend directory and run command npm i
@ Look it's downloading some packages and libraries and storing in the node_modules directory of the frontend project. Wait till download is fully completed.
@ Once done make sure you are in the root directory of frontend and xampp/wampp is running. Open cmd and run command npm run server
@ Once compilation is completed then you will see url in the cmd and copy it and call it in the web browser you will get the view

Note: The frontend is still in under development mode. You can publish it before host using command npm run build.




Instruction for project management backend with frontend
------------------------------------------------------------

## Laravel RestFul API

*/api/login
*/api/register
*/api/verify-user/token/target /* here token is a random string and target is a encrypted email with base64_encrypt */

*/api/user/usthed-user
*/api/user/logout
*/api/user/create-todo
*/api/user/my-todos/limit (todos created by specific user, sending fetch limit from frontend)

*/api/user/my-todo/id
*/api/user/update-todo/id
*/api/user/delete-todo/id
*/api/user/search-todo


## Vue.js frontend
-------------------------

- There is 6 main screen mainly, all screen is devided into component (Welcome, Register, Login, Profile, AddTodo and Single)
- Header, Message and Table is used in page components seperately,
- in the vue setting main.js there you will find 

Vue.prototype.$axios = axios;
Vue.prototype.$base_path = 'example.com'

this are most commonly used custom prototype in every component
base_path is the rest api domain url such as exampl.com. It's located in routed folder
when you will upload the back to a server you have to mention the server address in base directory
such as base_path = 'www.example.com'

- In router directory you will findout another file name index.js. Its for routing, al the component is linked with the index.js.



const routes = [
    { 
        path: '/', 
        component: Welcome,
        name: 'welcome',
        meta: { title: 'Welcome Page' },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('user_token') ? true : false;
            if(token === true)
            {
                next('/profile');   
            }
            next();
        }
    },
    { 
        path: '/login', 
        component: Login,
        name: 'login',
        meta: { title: 'Login Page' },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('user_token') ? true : false;
            if(token === true)
            {
                next('/profile');   
            }
            next();
        }
    },
    { 
        path: '/register', 
        component: Register,
        name: 'register',
        meta: { title: 'Register Page' },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('user_token') ? true : false;
            if(token === true)
            {
                next('/profile');   
            }
            next();
        }
    },
    { 
        path: '/profile', 
        component: Profile,
        name: 'profile',
        meta: { title: 'Profile Page' },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('user_token') ? true : false;
            if(token !== true)
            {
                next('/login');   
            }
            next();
        }
    },
    { 
        path: '/add-todo', 
        component: AddTodo,
        name: 'addTodo',
        meta: { title: 'Add new todo' },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('user_token') ? true : false;
            if(token !== true)
            {
                next('/login');   
            }
            next();
        }
    },
    { 
        path: '/edit-todo/:id', 
        component: AddTodo,
        name: 'UpdateTodo',
        meta: { title: 'Edit todo' },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('user_token') ? true : false;
            if(token !== true)
            {
                next('/login');   
            }
            next();
        }
    },
    { 
        path: '/view-todo/:id', 
        component: Single,
        name: 'ViewTodo',
        meta: { title: 'Single Todo Item' },
        beforeEnter: (to, from, next) => {
            const token = localStorage.getItem('user_token') ? true : false;
            if(token !== true)
            {
                next('/login');   
            }
            next();
        }
    }
]

beforeEnter is a vue middleware function which helps to apply logic in router.

- Welcome.vue is a welcome screen which will be access by guest user not by logedin user
- Register.vue is acceesable to guest user and register for a account
- Once Registration is completed then user can not login to account till they verify email.
- User will check email and get a lick to verify email.
- Login.vue User can login once login then can not acceess login page till logout
- Profile.vue will show after login only and show user created todos.
- User will be able to create new todo, update todo, delete and view. All the otodos are private by user. One can not access to another todo.
- Finally user will logout (Note: jwt token wont be exprired so user will be logedin till they don't hit logout)

Thanks.