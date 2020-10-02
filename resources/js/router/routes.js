import UserPosts from "../components/User/UserPosts";
import UserComments from "../components/User/UserComments";
import CategoryAllDetails from "../components/User/Details/CategoryAllDetails";
import DetailsIndexSubs from "../components/User/Details/DetailsIndexSubs";
import DetailsIndexRegulations from "../components/User/Details/DetailsIndexRegulations";
import UserAllDetails from "../components/User/Details/UserAllDetails";

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
      {path: 'comments', name: 'user.comments', component: UserComments},
      {
        path: 'details',
        component: page('user/details/index.vue'),
        children: [
          {path: '', name: 'user.details', component: UserAllDetails},
          {path: 'subscribers', name: 'user.subscribers', component: DetailsIndexSubs},
          {path: 'subscriptions', name: 'user.subscriptions', component: DetailsIndexSubs},
        ]
      }
    ]
  },
  {path: '/settings', name: 'settings', component: page('settings/index.vue')},
  {path: '/subs', name: 'subs', component: page('category/index.vue')},

  {
    path: '/:slug',
    component: page('category/category.vue'),
    children: [
      {path: '', name: 'subsite', component: UserPosts},
      {
        path: 'details',
        component: page('category/details/index.vue'),
        children: [
          {path: '', name: 'subsite.details', component: CategoryAllDetails},
          {path: 'subscribers', name: 'subsite.subscribers', component: DetailsIndexSubs},
          {path: 'rules', name: 'subsite.rules', component: DetailsIndexRegulations},
        ]
      }
    ]
  },

  {path: '*', component: page('errors/404.vue')}
]
