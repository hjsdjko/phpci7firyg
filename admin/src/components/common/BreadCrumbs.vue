<template>
	<div class="breadcrumb-preview">
		<el-breadcrumb :style='{"width":"100%","lineHeight":"65px","fontSize":"inherit","background":"none","justifyContent":"flex-end","display":"flex"}' separator=">">
			<transition-group name="breadcrumb" class="box">
				<el-breadcrumb-item v-for="(item,index) in levelList" :key="item.path">
					<span v-if="item.redirect==='noRedirect'||index==levelList.length-1" class="no-redirect">{{ item.name }}</span>
					<a v-else @click.prevent="handleLink(item)">
						<span class="icon iconfont icon-home7" :style='{"margin":"0 6px 0 0","lineHeight":"1","fontSize":"inherit","color":"#333","display":"none"}'></span>Dashboard
					</a>
				</el-breadcrumb-item>
			</transition-group>
		</el-breadcrumb>
	</div>
</template>

<script>
import pathToRegexp from 'path-to-regexp'
import { generateTitle } from '@/utils/i18n'
export default {
  data() {
    return {
      levelList: null
    }
  },
  watch: {
    $route() {
      this.getBreadcrumb()
    }
  },
  created() {
    this.getBreadcrumb()
  },
  methods: {
    generateTitle,
    getBreadcrumb() {
      // only show routes with meta.title
      let route = this.$route
      let matched = route.matched.filter(item => item.meta)
      const first = matched[0]
      matched = [{ path: '/index' }].concat(matched)

      this.levelList = matched.filter(item => item.meta)
    },
    isDashboard(route) {
      const name = route && route.name
      if (!name) {
        return false
      }
      return name.trim().toLocaleLowerCase() === 'Index'.toLocaleLowerCase()
    },
    pathCompile(path) {
      // To solve this problem https://github.com/PanJiaChen/vue-element-admin/issues/561
      const { params } = this.$route
      var toPath = pathToRegexp.compile(path)
      return toPath(params)
    },
    handleLink(item) {
      const { redirect, path } = item
      if (redirect) {
        this.$router.push(redirect)
        return
      }
      if(path){
      		  this.$router.push(path)
      }else{
      		  this.$router.push('/')
      }
    },
  }
}
</script>

<style lang="scss" scoped>
	.el-breadcrumb {
		& /deep/ .el-breadcrumb__separator {
		  		  margin: 0 4px;
		  		  color: #fff;
		  		  font-weight: 500;
		  		  font-size: 13px;
		  		}
		
		& /deep/ .el-breadcrumb__inner a {
		  		  color: #fff;
		  		  font-weight: 500;
		  		  display: inline-block;
		  		}
		
		& /deep/ .el-breadcrumb__inner {
		  		  color: #fff;
		  		  display: inline-block;
		  		}
	}
</style>
