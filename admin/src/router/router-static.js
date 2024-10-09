import Vue from 'vue';
//配置路由
import VueRouter from 'vue-router'
Vue.use(VueRouter);
//1.创建组件
import Index from '@/views/index'
import Home from '@/views/home'
import Login from '@/views/login'
import NotFound from '@/views/404'
import UpdatePassword from '@/views/update-password'
import pay from '@/views/pay'
import register from '@/views/register'
import center from '@/views/center'
    import news from '@/views/modules/news/list'
    import yuangong from '@/views/modules/yuangong/list'
    import kefangyuding from '@/views/modules/kefangyuding/list'
    import aboutus from '@/views/modules/aboutus/list'
    import ruzhudengji from '@/views/modules/ruzhudengji/list'
    import kefangxinxi from '@/views/modules/kefangxinxi/list'
    import kefangleixing from '@/views/modules/kefangleixing/list'
    import tuifangdengji from '@/views/modules/tuifangdengji/list'
    import caipinxinxi from '@/views/modules/caipinxinxi/list'
    import caipinfenlei from '@/views/modules/caipinfenlei/list'
    import discusskefangxinxi from '@/views/modules/discusskefangxinxi/list'
    import systemintro from '@/views/modules/systemintro/list'
    import kehu from '@/views/modules/kehu/list'
    import chat from '@/views/modules/chat/list'
    import kefangweixiu from '@/views/modules/kefangweixiu/list'
    import discusscaipinxinxi from '@/views/modules/discusscaipinxinxi/list'
    import config from '@/views/modules/config/list'
    import caipindingdan from '@/views/modules/caipindingdan/list'
    import xuzhudengji from '@/views/modules/xuzhudengji/list'
    import newstype from '@/views/modules/newstype/list'


//2.配置路由   注意：名字
export const routes = [{
    path: '/',
    name: '系统首页',
    component: Index,
    children: [{
      // 这里不设置值，是把main作为默认页面
      path: '/',
      name: '系统首页',
      component: Home,
      meta: {icon:'', title:'center', affix: true}
    }, {
      path: '/updatePassword',
      name: '修改密码',
      component: UpdatePassword,
      meta: {icon:'', title:'updatePassword'}
    }, {
      path: '/pay',
      name: '支付',
      component: pay,
      meta: {icon:'', title:'pay'}
    }, {
      path: '/center',
      name: '个人信息',
      component: center,
      meta: {icon:'', title:'center'}
    }
      ,{
	path: '/news',
        name: '酒店公告',
        component: news
      }
      ,{
	path: '/yuangong',
        name: '员工',
        component: yuangong
      }
      ,{
	path: '/kefangyuding',
        name: '客房预订',
        component: kefangyuding
      }
      ,{
	path: '/aboutus',
        name: '关于我们',
        component: aboutus
      }
      ,{
	path: '/ruzhudengji',
        name: '入住登记',
        component: ruzhudengji
      }
      ,{
	path: '/kefangxinxi',
        name: '客房信息',
        component: kefangxinxi
      }
      ,{
	path: '/kefangleixing',
        name: '客房类型',
        component: kefangleixing
      }
      ,{
	path: '/tuifangdengji',
        name: '退房登记',
        component: tuifangdengji
      }
      ,{
	path: '/caipinxinxi',
        name: '菜品信息',
        component: caipinxinxi
      }
      ,{
	path: '/caipinfenlei',
        name: '菜品分类',
        component: caipinfenlei
      }
      ,{
	path: '/discusskefangxinxi',
        name: '客房信息评论',
        component: discusskefangxinxi
      }
      ,{
	path: '/systemintro',
        name: '系统简介',
        component: systemintro
      }
      ,{
	path: '/kehu',
        name: '客户',
        component: kehu
      }
      ,{
	path: '/chat',
        name: '在线客服',
        component: chat
      }
      ,{
	path: '/kefangweixiu',
        name: '客房维修',
        component: kefangweixiu
      }
      ,{
	path: '/discusscaipinxinxi',
        name: '菜品信息评论',
        component: discusscaipinxinxi
      }
      ,{
	path: '/config',
        name: '轮播图管理',
        component: config
      }
      ,{
	path: '/caipindingdan',
        name: '菜品订单',
        component: caipindingdan
      }
      ,{
	path: '/xuzhudengji',
        name: '续住登记',
        component: xuzhudengji
      }
      ,{
	path: '/newstype',
        name: '酒店公告分类',
        component: newstype
      }
    ]
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {icon:'', title:'login'}
  },
  {
    path: '/register',
    name: 'register',
    component: register,
    meta: {icon:'', title:'register'}
  },
  {
    path: '*',
    component: NotFound
  }
]
//3.实例化VueRouter  注意：名字
const router = new VueRouter({
  mode: 'hash',
  /*hash模式改为history*/
  routes // （缩写）相当于 routes: routes
})
const originalPush = VueRouter.prototype.push
//修改原型对象中的push方法
VueRouter.prototype.push = function push(location) {
   return originalPush.call(this, location).catch(err => err)
}
export default router;
