import VueRouter from 'vue-router'
import store from './store'

let routes = [
    {
        path: '/admin/register',
        name: 'RegisterAdmin',
        component: require('./pages/RegisterAdmin').default,
        meta: {
            requireLogin: false
        }
    },
    {
        path: '/admin',
        name: 'LoginAdmin',
        component: require('./pages/LoginAdmin').default,
        meta: {
            requireLogin: false
        }
    },
    {
        path: '/register',
        name: 'RegisterCustomer',
        component: require('./pages/RegisterCustomer').default,
        meta: {
            requireLogin: false
        }
    },
    {
        path: '/login',
        name: 'LoginCustomer',
        component: require('./pages/LoginCustomer').default,
        meta: {
            requireLogin: false
        }
    },
    {
        path: '/',
        name: 'ProductList',
        component: require('./pages/ProductList').default,
        meta: {
            requireLogin: true
        }
    },
]

let router = new VueRouter({
	mode: 'history',
	routes
});

router.beforeEach(
	(to, from, next) => {
		if(!to.meta.requireLogin) {
			next();
		} else {
			if(!localStorage.getItem('accessToken')) {
			  next({
				name: 'LoginCustomer',
			  })
			} else {
				if(!store.getters.accessToken) {
					let loginObject = {
                        accessToken: localStorage.getItem('accessToken'),
                        userInfo: JSON.parse(localStorage.getItem('userInfo')),
					}
					store.dispatch('setUserState', loginObject);
					axios.defaults.headers.common['Authorization'] = 'Bearer ' + store.getters.accessToken;
				}
				next();
			}
		}
	}
);

export default router;
