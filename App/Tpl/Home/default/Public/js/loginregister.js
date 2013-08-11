$(function(){
	var js=document.scripts;
	var jsPath=js[js.length-1].src.substring(0,js[js.length-1].src.lastIndexOf("/")+1);
	var parentPath=jsPath.substring(0, jsPath.lastIndexOf("/"));
	parentPath = parentPath.substring(0, parentPath.lastIndexOf("/")+1);

	var register=$("#register-form");
	var submitButton=$("#regbtn").closest("a");

	if(register.length){
		$("#regunam").trigger("focus");	// 用户名输入框获得焦点

		if ($.browser.msie) {
			register.find("i").css("display","block");

			register.delegate("i", "click", function(i){
				var j=$(this);
				j.css("display", "none").siblings("input").trigger("focus");
			});

			register.delegate("<input[type=text],input[type=password]", "focus focusout", function(i){
				var j=$(this);
				if (i.type==="focusin") {
					j.siblings("i").css("display","none");
				}
				else{
					$.trim(j.val())===""&&j.siblings("i").css("display", "block");
				}
			});
		};

		f={
			checkPass:function(){
				var n=register.find("input[type=text],input[type=password],#reg-fuwu");
				var m={},k=n.length,l;
				for(var j=0;j<k;j++){
					l=n[j];
					if(!$(l).data("verified")){
						m.flag=true;
						m.message=$(l).siblings(".reg-tips").text();
						submitButton.addClass("abtn-no");
						break
					}
				}

				return m
			},
			verificate:function(){
				var i=register.find("input[type=text], input[type=password]");
				i.each(function(l,k){
					var n=$(k),j=n.attr("name"),m;
					f[j](this);
				})
			},
			username:function(j){
				var element=$(j);
				var tips=element.siblings(".reg-tips");
				var name=$.trim(element.val());
				if(/^[0-9a-zA-Z\u4e00-\u9fa5_-]{2,20}$/.test(name)){
					f.asyncCheck(j);
				}
				else{
					element.data("verified", false).addClass("reg-error");
					if(name.length==0){
						tips.html("用户名不能为空");
					}
					else{
						tips.html("2-20个字符，请勿使用特殊字符");
					}
					register.removeData("smt");
				}
			},
			email:function(j){
				var element=$(j);
				var mail=element.val();
				if (mail && mail.length>4 && /^[0-9a-z_][_.0-9a-z-]{0,31}@([0-9a-z][0-9a-z-]{0,30}\.){1,4}[a-z]{2,4}$/.test(mail)) {
					f.asyncCheck(j);
				}
				else{
					element.data("verified", false).addClass("reg-error").siblings(".reg-tips").html("请输入一个有效的e-mail地址");
					register.removeData("smt");
				};
			},
			pswd:function(j){
				var element=$(j);
				var value=element.val();
				if(value && value.length>=6 && value.length<=32){
					element.data("verified", true).removeClass("reg-error").siblings(".reg-tips").html('<img src="'+parentPath+'img/regyes.gif" width="30" height="30">');
				}
				else{
					element.data("verified", false).addClass("reg-error").siblings(".reg-tips").html("密码由6-32为字符组成")
					register.removeData("smt");
				}
			},
			asyncCheck:function(l){
				var element=$(l), isasync=element.data("isasync"), checkData=element.data("check");
				if (!checkData || isasync) {
					return;
				};

				var n=checkData.name;
				var u=checkData.url;
				element.data("isasync", true);

				var url=$("#check_post_action").val();

				var k;
				clearTimeout(k);
				k=setTimeout(function(){
					$.ajax({url:url,data:n+"="+encodeURIComponent(element.val()),  timeout:3000, 
						mysuccess:function(q, r){
							element.data("verified",true).removeClass("reg-error").siblings(".reg-tips").html('<img src="'+parentPath+'img/regyes.gif" width="30" height="30">');
						},
						myfailure:function(q, r){
							element.data("verified",false).addClass("reg-error").siblings(".reg-tips").html(q.message);
							register.removeData("smt");
						}

					}).always(
						function(){
							element.data("isasync",false)
						}
					);
				})
			}
		}

		register.delegate("input[type=text], input[type=password]", "blur", function(e){
			var j=$(this);
			f[j.attr("name")](this);
			if (register.type==="focusout" && j.data("verified") && !j.data("isasync")) {
				f.asyncCheck(this);
			};
		});

		register.delegate("input[type=text]", "focus", function(i){
			$(this).data("verified",true);
			submitButton.removeClass("abtn-no");
		});

		register.delegate("input[type=text], input[type=password]", "focus", function(e){
			var j=$(this);
			j.siblings(".reg-tips").empty();
			submitButton.removeClass("abtn-no");
		});

		register.delegate("#reg-fuwu","change",function(i){
			var j=$(this);
			if(j.attr("checked")){
				submitButton.removeClass("abtn-no")
			}
			else{
				submitButton.addClass("abtn-no")
			}
		});

		register.safeSubmit(function(j){
			if (register.data("smt") || submitButton.hasClass("abtn-no")) {
				alert("return");
				return;
			};
			register.data("smt",true);
			f.verificate();
			var k=f.checkPass(),i;
			clearTimeout(i);
			i=setTimeout(function(){
				if(!k.flag){
					register.unbind("safeSubmit");
					register.submit()
				}
			},200)
		})
	}
}
)