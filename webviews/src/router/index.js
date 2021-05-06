import Vue from 'vue'
import VueRouter from 'vue-router'
import Welcome from '../components/Welcome'
import Login from '../components/Login'
import Register from '../components/Register'
import Profile from '../components/Profile'
import AddTodo from '../components/AddTodo'
import Single from '../components/Single'


Vue.use(VueRouter)

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
  

const router = new VueRouter({
    mode: 'history',
    routes,
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title
    next()
  })

export default router
  