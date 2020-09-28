import UserPosts from "../components/User/UserPosts";
import UserComments from "../components/User/UserComments";

function page(path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  {path: '/', name: 'index', component: page('index.vue')},
  {path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue')},
  {path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue')},
  {path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue')},
  {
    path: '/u/:id',
    component: page('user.vue'),
    children: [
      {path: '', name: 'home', component: UserPosts},
      {path: 'comments', name: 'user.comments', component: UserComments}
    ]
  },
  {path: '/settings', name: 'settings', component: page('settings/index.vue')},
  {path: '/subs', name: 'subs', component: page('category/index.vue')},
  {path: '/:slug', name: 'subsite', component: page('category/category.vue'),},

  {path: '*', component: page('errors/404.vue')}
]
