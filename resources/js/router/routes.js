import UserPosts from "../components/User/UserPosts";
import UserComments from "../components/User/UserComments";
import CategoryAllDetails from "../components/User/Details/CategoryAllDetails";
import DetailsIndexSubs from "../components/User/Details/DetailsIndexSubs";
import DetailsIndexRegulations from "../components/User/Details/DetailsIndexRegulations";
import UserAllDetails from "../components/User/Details/UserAllDetails";
import UserDrafts from "../components/User/UserDrafts";
import MainInfo from "../components/User/Settings/MainInfo";
import NotificationSetting from "../components/User/Settings/NotificationSetting";
import BlockList from "../components/User/Settings/BlockList";

function page(path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  {path: '/404', name:'404', component: page('errors/404.vue')},
  {path: '/403', name:'403', component: page('errors/403.vue')},
  {
    path: '/',
    component: page('index.vue'),
    name: 'index',
    children: [
      {path: 'new', name: 'index.new', component: page('index.vue')},
      {path: 'all', name: 'index.all', component: page('index.vue')},
      {path: 'all/new', name: 'index.all.new', component: page('index.vue')},
    ],
  },
  {path: '/rating', name: 'rating', component: page('rating.vue')},
  {path: '/subs', name: 'subs', component: page('category/index.vue')},
  {path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue')},
  {path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue')},
  {path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue')},
  {
    path: '/u/:slug',
    component: page('user.vue'),
    children: [
      {path: '', name: 'user', component: UserPosts},
      {path: 'new', name: 'user.new', component: UserPosts},
      {path: 'comments', name: 'user.comments', component: UserComments},
      {path: 'comments/new', name: 'user.comments.new', component: UserComments},
      {path: 'drafts', name: 'user.drafts', component: UserDrafts},
      {
        path: 'details',
        component: page('user/details/index.vue'),
        children: [
          {path: '', name: 'user.details', component: UserAllDetails},
          {path: 'subscribers', name: 'user.subscribers', component: DetailsIndexSubs},
          {path: 'subscriptions', name: 'user.subscriptions', component: DetailsIndexSubs},
        ]
      },
    ],
  },
  {path: '/u/:slug/favorites', name: 'user.favorites', component: page('user/favorites.vue')},
  {path: '/u/:slug/favorites/comments', name: 'user.favorites.comments', component: page('user/favorites.vue')},
  {path: '/u/:slug/notifications', name: 'user.notifications', component: page('user/notifications.vue')},
  {
    path: '/u/:slug/settings',
    component: page('user/settings/index.vue'),
    name: 'user.settings',
    children: [
      {path: 'main', name: 'user.settings.main', component: MainInfo},
      {path: 'notifications', name: 'user.settings.notifications', component: NotificationSetting},
      {path: 'blocklist', name: 'user.settings.blocklist', component: BlockList},
    ]
  },
  {path: '/u/:slug/:postSlug', name: 'user.post', component: page('post.vue')},
  {
    path: '/:slug',
    component: page('category/category.vue'),
    children: [
      {path: '', name: 'category', component: UserPosts},
      {path: 'new', name: 'category.new', component: UserPosts},
      {
        path: 'details',
        component: page('category/details/index.vue'),
        children: [
          {path: '', name: 'category.details', component: CategoryAllDetails},
          {path: 'subscribers', name: 'category.subscribers', component: DetailsIndexSubs},
          {path: 'rules', name: 'category.rules', component: DetailsIndexRegulations},
        ]
      }
    ]
  },

  {path: '/:slug/:postSlug', name: 'post', component: page('post.vue')},
]
