<template>
	<div>
		<div class="container" :style='{"minHeight":"100vh","alignItems":"center","background":"url(http://codegen.caihongy.cn/20231118/03ccfac983fd4dac8fa98ccb357ee0dc.jpg)","display":"flex","width":"100%","backgroundSize":"100% 100%","backgroundPosition":"center center","backgroundRepeat":"no-repeat","justifyContent":"center"}'>
			<el-form v-if="pageFlag=='register'" :style='{"border":"0px solid #f6f6f6","padding":"40px 40px 40px 580px","boxShadow":"-15px 15px 15px rgb(6 17 47 / 70%)","margin":"20px 0","alignItems":"flex-start","textAlign":"center","display":"flex","justifyContent":"flex-start","minHeight":"600px","borderRadius":"0px","flexWrap":"wrap","background":"url(http://codegen.caihongy.cn/20231118/bc6bba657fa6436aa66620dcc5270163.jpg) repeat-y right center,url(http://codegen.caihongy.cn/20231118/ef8fde72b1aa416588d23b09f1998967.jpg) no-repeat right center / cover,#fff","width":"880px","height":"auto"}' ref="rgsForm" class="rgs-form" :model="rgsForm" :rules="rules">
				<div v-if="true" :style='{"padding":"0px","margin":"0 0 10px","borderColor":"#eee","color":"#2b9afc","textAlign":"left","display":"inline-block","background":"none","borderWidth":"0px","width":"100%","lineHeight":"40px","fontSize":"20px","borderStyle":"solid","fontWeight":"500"}' class="title">万怡酒店管理系统注册</div>
				<el-form-item :style='{"padding":"0 0px","margin":"0 20px 5px","textAlign":"left","flexWrap":"wrap","display":"flex","width":"230px","fontSize":"inherit","position":"relative","height":"auto"}' class="list-item" v-if="tableName=='yuangong'">
					<div v-if="true" :style='{"padding":"0 6px","color":"#333","textAlign":"right","left":"-120px","display":"inline-block","width":"120px","lineHeight":"40px","fontSize":"14px","position":"absolute","order":"2"}' class="lable" :class="changeRules('yuangonggonghao')?'required':''">员工工号：</div>
					<el-input  v-model="ruleForm.yuangonggonghao"  autocomplete="off" placeholder="员工工号"  type="text"  />
				</el-form-item>
				<el-form-item :style='{"padding":"0 0px","margin":"0 20px 5px","textAlign":"left","flexWrap":"wrap","display":"flex","width":"230px","fontSize":"inherit","position":"relative","height":"auto"}' class="list-item" v-if="tableName=='yuangong'">
					<div v-if="true" :style='{"padding":"0 6px","color":"#333","textAlign":"right","left":"-120px","display":"inline-block","width":"120px","lineHeight":"40px","fontSize":"14px","position":"absolute","order":"2"}' class="lable" :class="changeRules('yuangongxingming')?'required':''">员工姓名：</div>
					<el-input  v-model="ruleForm.yuangongxingming"  autocomplete="off" placeholder="员工姓名"  type="text"  />
				</el-form-item>
				<el-form-item :style='{"padding":"0 0px","margin":"0 20px 5px","textAlign":"left","flexWrap":"wrap","display":"flex","width":"230px","fontSize":"inherit","position":"relative","height":"auto"}' class="list-item" v-if="tableName=='yuangong'">
					<div v-if="true" :style='{"padding":"0 6px","color":"#333","textAlign":"right","left":"-120px","display":"inline-block","width":"120px","lineHeight":"40px","fontSize":"14px","position":"absolute","order":"2"}' class="lable" :class="changeRules('mima')?'required':''">密码：</div>
					<el-input  v-model="ruleForm.mima"  autocomplete="off" placeholder="密码"  type="password"  />
				</el-form-item>
				<el-form-item :style='{"padding":"0 0px","margin":"0 20px 5px","textAlign":"left","flexWrap":"wrap","display":"flex","width":"230px","fontSize":"inherit","position":"relative","height":"auto"}' class="list-item" v-if="tableName=='yuangong'">
					<div v-if="true" :style='{"padding":"0 6px","color":"#333","textAlign":"right","left":"-120px","display":"inline-block","width":"120px","lineHeight":"40px","fontSize":"14px","position":"absolute","order":"2"}' class="lable" :class="changeRules('mima')?'required':''">确认密码：</div>
					<el-input  v-model="ruleForm.mima2" autocomplete="off" placeholder="确认密码" type="password" />
				</el-form-item>
				<el-form-item :style='{"padding":"0 0px","margin":"0 20px 5px","textAlign":"left","flexWrap":"wrap","display":"flex","width":"230px","fontSize":"inherit","position":"relative","height":"auto"}' class="list-item" v-if="tableName=='yuangong'">
					<div v-if="true" :style='{"padding":"0 6px","color":"#333","textAlign":"right","left":"-120px","display":"inline-block","width":"120px","lineHeight":"40px","fontSize":"14px","position":"absolute","order":"2"}' class="lable" :class="changeRules('touxiang')?'required':''">头像：</div>
                    <file-upload
                        tip="点击上传头像"
                        action="file/upload"
                        :limit="3"
                        :multiple="true"
                        :fileUrls="ruleForm.touxiang?ruleForm.touxiang:''"
                        @change="yuangongtouxiangUploadChange"
                    ></file-upload>
				</el-form-item>
				<el-form-item :style='{"padding":"0 0px","margin":"0 20px 5px","textAlign":"left","flexWrap":"wrap","display":"flex","width":"230px","fontSize":"inherit","position":"relative","height":"auto"}' class="list-item" v-if="tableName=='yuangong'">
					<div v-if="true" :style='{"padding":"0 6px","color":"#333","textAlign":"right","left":"-120px","display":"inline-block","width":"120px","lineHeight":"40px","fontSize":"14px","position":"absolute","order":"2"}' class="lable" :class="changeRules('xingbie')?'required':''">性别：</div>
                    <el-select v-model="ruleForm.xingbie" placeholder="请选择性别" >
                        <el-option
                            v-for="(item,index) in yuangongxingbieOptions"
                            v-bind:key="index"
                            :label="item"
                            :value="item">
                        </el-option>
                    </el-select>
				</el-form-item>
				<el-form-item :style='{"padding":"0 0px","margin":"0 20px 5px","textAlign":"left","flexWrap":"wrap","display":"flex","width":"230px","fontSize":"inherit","position":"relative","height":"auto"}' class="list-item" v-if="tableName=='yuangong'">
					<div v-if="true" :style='{"padding":"0 6px","color":"#333","textAlign":"right","left":"-120px","display":"inline-block","width":"120px","lineHeight":"40px","fontSize":"14px","position":"absolute","order":"2"}' class="lable" :class="changeRules('lianxidianhua')?'required':''">联系电话：</div>
					<el-input  v-model="ruleForm.lianxidianhua"  autocomplete="off" placeholder="联系电话"  type="text"  />
				</el-form-item>
				<el-form-item :style='{"padding":"0 0px","margin":"0 20px 5px","textAlign":"left","flexWrap":"wrap","display":"flex","width":"230px","fontSize":"inherit","position":"relative","height":"auto"}' class="list-item" v-if="tableName=='kehu'">
					<div v-if="true" :style='{"padding":"0 6px","color":"#333","textAlign":"right","left":"-120px","display":"inline-block","width":"120px","lineHeight":"40px","fontSize":"14px","position":"absolute","order":"2"}' class="lable" :class="changeRules('kehuzhanghao')?'required':''">客户账号：</div>
					<el-input  v-model="ruleForm.kehuzhanghao"  autocomplete="off" placeholder="客户账号"  type="text"  />
				</el-form-item>
				<el-form-item :style='{"padding":"0 0px","margin":"0 20px 5px","textAlign":"left","flexWrap":"wrap","display":"flex","width":"230px","fontSize":"inherit","position":"relative","height":"auto"}' class="list-item" v-if="tableName=='kehu'">
					<div v-if="true" :style='{"padding":"0 6px","color":"#333","textAlign":"right","left":"-120px","display":"inline-block","width":"120px","lineHeight":"40px","fontSize":"14px","position":"absolute","order":"2"}' class="lable" :class="changeRules('kehuxingming')?'required':''">客户姓名：</div>
					<el-input  v-model="ruleForm.kehuxingming"  autocomplete="off" placeholder="客户姓名"  type="text"  />
				</el-form-item>
				<el-form-item :style='{"padding":"0 0px","margin":"0 20px 5px","textAlign":"left","flexWrap":"wrap","display":"flex","width":"230px","fontSize":"inherit","position":"relative","height":"auto"}' class="list-item" v-if="tableName=='kehu'">
					<div v-if="true" :style='{"padding":"0 6px","color":"#333","textAlign":"right","left":"-120px","display":"inline-block","width":"120px","lineHeight":"40px","fontSize":"14px","position":"absolute","order":"2"}' class="lable" :class="changeRules('mima')?'required':''">密码：</div>
					<el-input  v-model="ruleForm.mima"  autocomplete="off" placeholder="密码"  type="password"  />
				</el-form-item>
				<el-form-item :style='{"padding":"0 0px","margin":"0 20px 5px","textAlign":"left","flexWrap":"wrap","display":"flex","width":"230px","fontSize":"inherit","position":"relative","height":"auto"}' class="list-item" v-if="tableName=='kehu'">
					<div v-if="true" :style='{"padding":"0 6px","color":"#333","textAlign":"right","left":"-120px","display":"inline-block","width":"120px","lineHeight":"40px","fontSize":"14px","position":"absolute","order":"2"}' class="lable" :class="changeRules('mima')?'required':''">确认密码：</div>
					<el-input  v-model="ruleForm.mima2" autocomplete="off" placeholder="确认密码" type="password" />
				</el-form-item>
				<el-form-item :style='{"padding":"0 0px","margin":"0 20px 5px","textAlign":"left","flexWrap":"wrap","display":"flex","width":"230px","fontSize":"inherit","position":"relative","height":"auto"}' class="list-item" v-if="tableName=='kehu'">
					<div v-if="true" :style='{"padding":"0 6px","color":"#333","textAlign":"right","left":"-120px","display":"inline-block","width":"120px","lineHeight":"40px","fontSize":"14px","position":"absolute","order":"2"}' class="lable" :class="changeRules('xingbie')?'required':''">性别：</div>
                    <el-select v-model="ruleForm.xingbie" placeholder="请选择性别" >
                        <el-option
                            v-for="(item,index) in kehuxingbieOptions"
                            v-bind:key="index"
                            :label="item"
                            :value="item">
                        </el-option>
                    </el-select>
				</el-form-item>
				<el-form-item :style='{"padding":"0 0px","margin":"0 20px 5px","textAlign":"left","flexWrap":"wrap","display":"flex","width":"230px","fontSize":"inherit","position":"relative","height":"auto"}' class="list-item" v-if="tableName=='kehu'">
					<div v-if="true" :style='{"padding":"0 6px","color":"#333","textAlign":"right","left":"-120px","display":"inline-block","width":"120px","lineHeight":"40px","fontSize":"14px","position":"absolute","order":"2"}' class="lable" :class="changeRules('lianxidianhua')?'required':''">联系电话：</div>
					<el-input  v-model="ruleForm.lianxidianhua"  autocomplete="off" placeholder="联系电话"  type="text"  />
				</el-form-item>
				<el-form-item :style='{"padding":"0 0px","margin":"0 20px 5px","textAlign":"left","flexWrap":"wrap","display":"flex","width":"230px","fontSize":"inherit","position":"relative","height":"auto"}' class="list-item" v-if="tableName=='kehu'">
					<div v-if="true" :style='{"padding":"0 6px","color":"#333","textAlign":"right","left":"-120px","display":"inline-block","width":"120px","lineHeight":"40px","fontSize":"14px","position":"absolute","order":"2"}' class="lable" :class="changeRules('shenfenzheng')?'required':''">身份证：</div>
					<el-input  v-model="ruleForm.shenfenzheng"  autocomplete="off" placeholder="身份证"  type="text"  />
				</el-form-item>
				<el-form-item :style='{"padding":"0 0px","margin":"0 20px 5px","textAlign":"left","flexWrap":"wrap","display":"flex","width":"230px","fontSize":"inherit","position":"relative","height":"auto"}' class="list-item" v-if="tableName=='kehu'">
					<div v-if="true" :style='{"padding":"0 6px","color":"#333","textAlign":"right","left":"-120px","display":"inline-block","width":"120px","lineHeight":"40px","fontSize":"14px","position":"absolute","order":"2"}' class="lable" :class="changeRules('touxiang')?'required':''">头像：</div>
                    <file-upload
                        tip="点击上传头像"
                        action="file/upload"
                        :limit="3"
                        :multiple="true"
                        :fileUrls="ruleForm.touxiang?ruleForm.touxiang:''"
                        @change="kehutouxiangUploadChange"
                    ></file-upload>
				</el-form-item>
				<button :style='{"border":"0px solid #4FA1D9","cursor":"pointer","padding":"0 24px","boxShadow":"0 0 0px rgba(64, 158, 255, .5)","margin":"20px 20px 0 0","color":"#fff","display":"inline-block","letterSpacing":"4px","outline":"none","borderRadius":"4px","background":"#2b9afc","width":"auto","fontSize":"16px","height":"40px"}' type="button" class="r-btn" @click="login()">注册</button>
				<div :style='{"cursor":"pointer","padding":"0","margin":"20px 0 0","color":"rgba(159, 159, 159, 1)","textAlign":"right","display":"inline-block","width":"auto","lineHeight":"44px","fontSize":"14px"}' class="r-login" @click="close()">已有账号，直接登录</div>
			</el-form>
			
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			ruleForm: {
			},
			forgetForm: {},
            pageFlag : '',
			tableName:"",
			rules: {},
            yuangongxingbieOptions: [],
            kehuxingbieOptions: [],
		};
	},
	mounted(){
		this.pageFlag = this.$route.query.pageFlag
		if(this.$route.query.pageFlag=='register'){
			
			let table = this.$storage.get("loginTable");
			this.tableName = table;
			if(this.tableName=='yuangong'){
				this.ruleForm = {
					yuangonggonghao: '',
					yuangongxingming: '',
					mima: '',
					touxiang: '',
					xingbie: '',
					lianxidianhua: '',
				}
			}
			if(this.tableName=='kehu'){
				this.ruleForm = {
					kehuzhanghao: '',
					kehuxingming: '',
					mima: '',
					xingbie: '',
					lianxidianhua: '',
					shenfenzheng: '',
					touxiang: '',
				}
			}
			if ('kehu' == this.tableName) {
				this.rules.kehuzhanghao = [{ required: true, message: '请输入客户账号', trigger: 'blur' }]
			}
			if ('kehu' == this.tableName) {
				this.rules.kehuxingming = [{ required: true, message: '请输入客户姓名', trigger: 'blur' }]
			}
			this.yuangongxingbieOptions = "男,女".split(',')
			this.kehuxingbieOptions = "男,女".split(',')
		}
	},
	created() {
	},
	destroyed() {
		  	},
	methods: {
		changeRules(name){
			if(this.rules[name]){
				return true
			}
			return false
		},
		// 获取uuid
		getUUID () {
			return new Date().getTime();
		},
		close(){
			this.$router.push({ path: "/login" });
		},
        yuangongtouxiangUploadChange(fileUrls) {
            this.ruleForm.touxiang = fileUrls;
        },
        kehutouxiangUploadChange(fileUrls) {
            this.ruleForm.touxiang = fileUrls;
        },

        // 多级联动参数


		// 注册
		login() {
			var url=this.tableName+"/register";
					if((this.ruleForm.mima!=this.ruleForm.mima2) && `yuangong` == this.tableName){
						this.$message.error(`两次密码输入不一致`);
						return
					}
            if(this.ruleForm.touxiang!=null) {
                this.ruleForm.touxiang = this.ruleForm.touxiang.replace(new RegExp(this.$base.url,"g"),"");
            }
					if(`yuangong` == this.tableName && this.ruleForm.lianxidianhua &&(!this.$validate.isMobile(this.ruleForm.lianxidianhua))){
						this.$message.error(`联系电话应输入手机格式`);
						return
					}
					if((!this.ruleForm.kehuzhanghao) && `kehu` == this.tableName){
						this.$message.error(`客户账号不能为空`);
						return
					}
					if((!this.ruleForm.kehuxingming) && `kehu` == this.tableName){
						this.$message.error(`客户姓名不能为空`);
						return
					}
					if((this.ruleForm.mima!=this.ruleForm.mima2) && `kehu` == this.tableName){
						this.$message.error(`两次密码输入不一致`);
						return
					}
					if(`kehu` == this.tableName && this.ruleForm.lianxidianhua &&(!this.$validate.isMobile(this.ruleForm.lianxidianhua))){
						this.$message.error(`联系电话应输入手机格式`);
						return
					}
					if(`kehu` == this.tableName && this.ruleForm.shenfenzheng &&(!this.$validate.checkIdCard(this.ruleForm.shenfenzheng))){
						this.$message.error(`身份证应输入身份证格式`);
						return
					}
            if(this.ruleForm.touxiang!=null) {
                this.ruleForm.touxiang = this.ruleForm.touxiang.replace(new RegExp(this.$base.url,"g"),"");
            }
			this.$http({
				url: url,
				method: "post",
				data:this.ruleForm
			}).then(({ data }) => {
				if (data && data.code === 0) {
					this.$message({
						message: "注册成功",
						type: "success",
						duration: 1500,
						onClose: () => {
							this.$router.replace({ path: "/login" });
						}
					});
				} else {
					this.$message.error(data.msg);
				}
			});
		}
	}
};
</script>

<style lang="scss" scoped>
	.container {
	  position: relative;
	  background: url(http://codegen.caihongy.cn/20231118/03ccfac983fd4dac8fa98ccb357ee0dc.jpg);

		.el-date-editor.el-input {
		  width: 100%;
		}
		
		.rgs-form .el-input /deep/ .el-input__inner {
						border: 1px solid #eee;
						border-radius: 4px;
						padding: 0 10px;
						box-shadow: 0 0 0px rgba(64, 158, 255, .3);
						color: #666;
						background: none;
						width: 100%;
						font-size: 14px;
						min-width: 220px;
						height: 36px;
					}
		
		.rgs-form .el-select /deep/ .el-input__inner {
						border: 1px solid #eee;
						border-radius: 4px;
						padding: 0 10px;
						box-shadow: 0 0 0px rgba(64, 158, 255, .3);
						color: #ccc;
						background: none;
						width: 100%;
						font-size: 14px;
						min-width: 220px;
						height: 36px;
					}
		
		.rgs-form .el-date-editor /deep/ .el-input__inner {
						border: 1px solid #eee;
						border-radius: 4px;
						padding: 0 10px 0 30px;
						box-shadow: 0 0 0px rgba(64, 158, 255, .3);
						color: #ccc;
						background: none;
						width: 100%;
						font-size: 14px;
						min-width: 220px;
						height: 36px;
					}
		
		.rgs-form .el-date-editor /deep/ .el-input__inner {
						border: 1px solid #eee;
						border-radius: 4px;
						padding: 0 10px 0 30px;
						box-shadow: 0 0 0px rgba(64, 158, 255, .3);
						color: #ccc;
						background: none;
						width: 100%;
						font-size: 14px;
						min-width: 220px;
						height: 36px;
					}
		
		.rgs-form /deep/ .el-upload--picture-card {
			background: transparent;
			border: 0;
			border-radius: 0;
			width: auto;
			height: auto;
			line-height: initial;
			vertical-align: middle;
		}
		
		.rgs-form /deep/ .upload .upload-img {
		  		  border: 1px solid #eee;
		  		  cursor: pointer;
		  		  border-radius: 4px;
		  		  margin: 2px 0 0;
		  		  color: #999;
		  		  background: none;
		  		  font-weight: 600;
		  		  width: 100px;
		  		  font-size: 18px;
		  		  line-height: 36px;
		  		  text-align: center;
		  		  height: 36px;
		  		}
		
		.rgs-form /deep/ .el-upload-list .el-upload-list__item {
		  		  border: 1px solid #eee;
		  		  cursor: pointer;
		  		  border-radius: 4px;
		  		  margin: 2px 0 0;
		  		  color: #999;
		  		  background: none;
		  		  font-weight: 600;
		  		  width: 100px;
		  		  font-size: 18px;
		  		  line-height: 36px;
		  		  text-align: center;
		  		  height: 36px;
		  		}
		
		.rgs-form /deep/ .el-upload .el-icon-plus {
		  		  border: 1px solid #eee;
		  		  cursor: pointer;
		  		  border-radius: 4px;
		  		  margin: 2px 0 0;
		  		  color: #999;
		  		  background: none;
		  		  font-weight: 600;
		  		  width: 100px;
		  		  font-size: 18px;
		  		  line-height: 36px;
		  		  text-align: center;
		  		  height: 36px;
		  		}
	}
	.required {
		position: relative;
	}
	.required::after{
				color: red;
				position: absolute;
				right: 3px;
				content: "*";
				order: 3;
			}
	.editor>.avatar-uploader {
		line-height: 0;
		height: 0;
	}
</style>
