import Vue from 'vue'
import Card from './Card'
import Child from './Child'
import Button from './Button'
import Checkbox from './Checkbox'
import Avatar from './User/Settings/Avatar'
import { HasError, AlertError, AlertSuccess } from 'vform'
import MainInfo from "./User/Settings/MainInfo";

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
  AlertSuccess
].forEach(Component => {
  Vue.component(Component.name, Component)
})
