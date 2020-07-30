import Vue from 'vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

// import { } from '@fortawesome/free-regular-svg-icons'

import {
  faUser, faLock, faSignOutAlt, faCog
} from '@fortawesome/free-solid-svg-icons'

import {
  faGithub
} from '@fortawesome/free-brands-svg-icons'

import {
  faGoogle
} from '@fortawesome/free-brands-svg-icons'

import {
  faTwitch
} from '@fortawesome/free-brands-svg-icons'

import {
  faFacebookF
} from '@fortawesome/free-brands-svg-icons'

import {
  faTwitter
} from '@fortawesome/free-brands-svg-icons'

library.add(
  faUser, faLock, faSignOutAlt, faCog, faGithub, faTwitter, faTwitch, faFacebookF, faGoogle
)

Vue.component('fa', FontAwesomeIcon)
