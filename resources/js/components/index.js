import Vue from 'vue'
import Card from './Card'
import Child from './Child'
import Button from './Button'
import Checkbox from './Checkbox'
import Avatar from './User/Avatar'
import { HasError, AlertError, AlertSuccess } from 'vform'
import MainInfo from "./User/Settings/MainInfo";
import SocialAuthBox from "./SocialAuthBox";
import LoginBox from "./LoginBox";
// Components that are registered globaly.
[
  Avatar,
  MainInfo,
  Card,
  Child,
  Button,
  Checkbox,
  HasError,
  AlertError,
  AlertSuccess,
  SocialAuthBox,
  LoginBox
].forEach(Component => {
  Vue.component(Component.name, Component)
})
