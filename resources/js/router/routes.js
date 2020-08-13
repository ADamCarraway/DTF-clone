import UserPosts from "../components/User/UserPosts";
import UserComments from "../components/User/UserComments";

function page(path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  {path: '/', name: 'index', component: page('index.vue')},

  // { path: '/login', name: 'login', component: page('auth/login.vue') },
  // { path: '/register', name: 'register', component: page('auth/register.vue') },
  // { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  {path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue')},
  {path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue')},
  {path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue')},

  {
    path: '/home',
    component: page('home.vue'),
    children: [
      {path: '', name: 'home', component: UserPosts},
      {path: 'comments', name: 'user.comments', component: UserComments}
    ]
  },
  {path: '/settings', name: 'settings', component: page('settings/index.vue')},

  {path: '*', component: page('errors/404.vue')}
]
// { path: '/settings',
//   component: page('settings/index.vue'),
//   children: [
//   { path: '', redirect: { name: 'settings.profile' } },
//   { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
//   { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
// ] },
