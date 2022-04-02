<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />
		<title>用户登录</title>
		<link rel="stylesheet"  href="index_log.css" />
    <style>
        *{
	/*初始化 清除页面元素的内外边距*/
	padding: 0;
	margin: 0;
	/*盒子模型*/
	box-sizing: border-box;
}
body {
	/*弹性布局 让页面元素垂直+水平居中*/
	display: flex;
	justify-content: center;
	align-items: center;
	/*让页面始终占浏览器可视区域总高度*/
	height: 100vh;
	position: absolute;  flex-direction: column; background-color: red;	flex: 1;
		width: 100%; height: 100%;  background: url(WOW.jpg)  no-repeat; background-size:100% 100%; background-attachment:fixed;
}
.login{
    margin: 0 auto;	/* login框剧中 */
    margin-top: 0; /* login框与顶部的距离 */
    padding: 20px 50px;	/* login框内部的距离(内部与输入框和按钮的距离) */
    background-color: #00000090;	/* login框背景颜色和透明度 */
    width: 400px;
    height: 350px;
    border-radius: 10px;	/* 圆角边 */
    text-align: center;	/* 框内所有内容剧中 */
    box-shadow: 0 15px 25px rgba(0, 0, 0, 0.4);

}

.login h1{
	color: #fff;
	margin-bottom: 30px;
}
.login .login_box {
	/*相对定位*/
	position: relative;
	width: 100%;
}
.login .login_box input{
	/*清除input框自带的边框和轮廓*/
	outline: none;
	border: none;
	width: 100%;
	padding: 10px 0;
	margin-bottom: 30px;
	color: #ffffff;
	font-size: 16px;
	border-bottom: 1px solid #fff;
	/*背景颜色为透明色*/
	background-color: transparent;
}

.login .login_box label{
	position:absolute;
	top: 0 ;
	left: 0;
	padding: 10px 0;
	color: #fff;
	/*这个属性的默认值是auto 默认是这个元素可以被点击
	但是如果我们写了none  就是这个元素不能被点击，就好像它可见但是不能用  
	可望而不可及*/
	/*这个就是两者的区别*/
	pointer-events: none;
	/*加个过度*/
	transition: all 0.5s;
}
/*: focus 选择器是当input获得焦点是触发的样式 + 是相邻兄弟选择器
	去找与input相邻的兄弟label*/
/*：valid 选择器是判断input 框的内容是否合法，如果合法会执行下面的属性代码，
	不合法就不会执行，我们刚开始写布局的时候给input框写了required 我们删掉看对比 
	当没有required的话   input框的值就会被认为一直合法，所以一直都是下方的样式，
	但是密码不会，密码框的值为空，那么这句话就不合法，required不能为空
	当我们给密码框写点东西的时候才会执行以下代码

*/
.login .login_box input:focus + label,
.login  .login_box input:valid + label{
	top: -20px;
	color: #f509e1;
	font-size: 12px;
}

.b a{
	/*overflow: hidden;*/
	position: relative;
	padding: 5px 15px;
	color: #fff;
	/*取消a表现原有的下划线*/
	text-decoration: none;
	/*同样加个过渡*/
	transition: all 0.5s;
}
.b a:hover {
	color: #fff;
	border-radius: 15px;
	background-color: #c8f407;
	box-shadow: 0 0 5px #c8f407,0 0 25px #c8f407,0 0 50px #c8f407,0 0 100px #c8f407;
}
.b a span{
	position: absolute;
}
.b a span:first-child {
	top: 0;
	left: -100%;
	width: 100%;
	height: 2px;
	/*to right 就是往右边 下面的同理*/
	background: linear-gradient(to right,transparent,#c8f407);
	/*动画 名称  时长 linear是匀速运动 infinite是无限次运动*/
	animation: move1 1s linear infinite;

}
.b a span:nth-child(2){
	right: 0;
	top: -100%;
	width: 2px;
	height: 100%;
	background: linear-gradient(transparent,#c8f407);
	/*这里多了个0.25s其实是延迟时间*/
	animation: move2 1s linear 0.25s infinite;
}

.b a span:nth-child(3){
	right: -100%;
	bottom: 0;
	width: 100%;
	height: 2px;
	background: linear-gradient(to left,transparent,#c8f407);

	animation: move3 1s linear 0.5s infinite;
}

.b a span:last-child{
	left: 0;
	bottom: -100%;
	width: 2px;
	height: 100%;
	background: linear-gradient(#c8f407,transparent);
	animation: move4 1s linear 0.75s infinite;
}
/*写一下动画 */
@keyframes move1{
	0%{
		left: -100%;

	}
	50%,
	100%{
		left: 100%;
	}
}

@keyframes move2{
	0%{
		top: -100%;

	}
	50%,
	100%{
		top: 100%;
	}
}

@keyframes move3{
	0%{
		right: -100%;

	}
	50%,
	100%{
		right: 100%;
	}
}

@keyframes move4{
	0%{
		bottom: -100%;

	}
	50%,
	100%{
		bottom: 100%;
	}
}
.m-left{
    margin-left: 30px;

}
.loginButton
{
    line-height: 25px; /*设置line-height与rongqi的height相等*/
	    text-align: center;
    margin-right: 30px;
    margin-top: 10px;	/* 按钮顶部与输入框的距离 */
    margin-bottom: 30px;
    width: 100px;
    height: 25px;
    color: white;	/* 按钮字体颜色 */
    border: 0; /* 删除按钮边框 */
    border-radius: 20px;	/* 按钮圆角边 */
    background-image: linear-gradient(to right, #b8cbb8 0%, #b8cbb8 0%, #b465da 0%, #cf6cc9 33%, #ee609c 66%, #ee609c 100%);	/* 按钮颜色 */
}
.register{
    position: absolute;
    right: 10px;
    color: #ffffff;
    /*left:  calc(5% - 200px);*/
    /* bottom: 200px; */
    font-size: 13px;
    margin-bottom: 10px;
}
.c{
	background-color: #00000090;
	color: #fff;
	box-shadow: 0 15px 25px rgba(0, 0, 0, 0.4);
}
.b{
	margin-bottom: 20px;
}
    </style>

	</head>

	<body>
		 <div class="login">
		 	<h1>用户登录</h1>
			 <form action="登陆2.php" method="post">
			<div class="login_box">
				<input type="text" name='Username' id='Username' required  />
				<label for="Username" >Username</label>
			</div>
			<div class="login_box">
				 
				<input type="password" name='Password' id='Password' required="required">
				<label for="Password">Password</label>
			</div>
			
           
            <div class="b">
                <a href="注册1.php">
				注册账号
                <span></span>
				<span></span>
				<span></span>
				<span></span>
            </a>
	
            </div>
			<div class="regiter">
                <a href="注册1.php"><input type="submit" id="regiter" name="login" value="登录" class="loginButton m-left"></a>
            </div>

		 </div>

	</body>
</html>
