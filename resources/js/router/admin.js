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
    return () => import(/* webpackChunkName: '' */ `~/pages/admin/${path}`).then(m => m.default || m)
}

export default [

]
