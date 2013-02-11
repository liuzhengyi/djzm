<?php
session_start();
include('config.php');
if(empty($_SESSION['mname'])) {
// 不是管理员，或未登录
} else {
// 是管理员，提供管理员控制台
	require('include/console_var.php');
}
?>

<?php require('include/dochead.php'); ?>
<body>
<div id="header">
<?php require('include/header.php'); ?>
</div> <!-- end of DIV header -->
<div id="body">
	<div id="main_content" class="content_block" >
		<h3>特色服务</h3>
		<p>艺术品代售购 开具权威机构证书 艺术品增值回购 会员制度</p>
		<ol>
		<li>艺术品代售购</li>
		<p>委托销售方式：</p>
		<ol>
		<li>请将作品送至我公司，经组委会审核达到要求的签订委托销售合同。</li>
		<li>将作品图片和作品详细介绍发送至购得艺术节邮箱（leezmin@163.com），我们会在1-2个工作日给您答复，符合销售条件的签订销售协议。 </li>
		</ol>
		<p>我公司真诚希望与各艺术家、收藏家、画廊、美术馆、艺术品销售机构等代理销售合作，共同开辟艺术品投资市场的新道路！</p>
		  
		<p>委托销售协议： </p>
		<p>第一条  艺术品权属：委托人应保证对艺术品拥有能够对抗第三方的所有权或处分权，应对艺术品的真伪、瑕疵向征集人做明确说明。 </p>
		<p>第二条  艺术品的交付、保管：委托人应在合同签订后2日内将艺术品交付征集人保管。委托人可同时提交艺术品的正视、俯视、底视照片，经征集人确认后双方均于照片背面签字，并交与征集人留存。征集人应承担艺术品自交付时起至售出或委托人取回时止的保管责任。</p>
		<p>第三条 作品标价：</p>
		<ol>
		<li>底价的确定。作品底价由征集人与委托方协商确定。</li>
		<li>商场标价。商场标价原则上由委托人与征集人协商制定，征集人可对销售价的确定提出专业性建议，征集人有根据商场销售情况有临时更改作品价格的权力。</li>
		</ol>
		<p>第四条  收费：</p>
		<p>佣金。以双方签订的网站代售协议而定。</p>
		<p>第五条  销售价款的支付：艺术品经商城成交的，在活动结束后，征集人按合同约定一个月后、三个月内扣除约定费用后如数支付成交款给委托人。</p>
		<p>第六条  艺术品的撤回与中止：委托人可以在上传到商场前撤回艺术品，但应按合同约定承担相关费用。如有证据表明艺术品在权属、真伪、瑕疵披露等方面存在不实之处，并因此可能导致社会公共利益、购买人利益或其它人合法权益受到损害的，征集人有权中止该作品出售，并及时通知委托人共同核实；经查证属实的，征集人有权解除合同，委托人对因此给征集人造成的损失负赔偿责任。</p>
		<p>第七条  争议解决方式：本合同项下发生的争议，由双方协商或申请调解解决；协商或调解解决不成的，按合同约定的方式解决。</p>
		<p>第八条  其它：未尽事宜，双方可书面另行约定，与法律、法规规定或不一致的，以法律、法规规定为准。有关行政管理部门对艺术品流转另有要求的，双方应按要求执行，征集人对由此产生的费用或造成的损失不承担责任。</p>
		<p>以上条款我公司拥有最终解释权。 </p>
		
		<li>艺术品增值回购</li>
		<p>计划一：买家收藏作品后我公司提供的质保证书、财务票据及协议书可向我公司提出回购申请。我我公司在检查作品品相完好及真伪后按作品成交价回购作品并按收藏年限支付相当比例的增值金。 </p>
		<p>计划二：买家收藏作品后凭我公司提供的质保证书、财务票据及协议书可向中心提出置换申请。我中心在检查作品品相完好及真伪后按高于作品成交价的一定比例置换艺术品。 </p>
		<p>我公司首次推出的收藏保值计划，既增强买家欣赏收藏艺术品的信心，又实现了艺术品的保值增值。</p>
		<p>部分作品享受此项服务。 </p>
		<li>开具收藏证书</li>
		<p>指定活动由我公司开具作品质保证书，确保商品保真、保值、保质。 </p>
		<p>以往活动质保证书例举： </p>
		<div class="certificate_display" >
		<img class="certificate_display" width="590" alt="certificate01" title="certificate01" src="pic/illustration/certificate01.jpg" />
		<img class="certificate_display" width="590" alt="certificate02" title="certificate02" src="pic/illustration/certificate02.jpg" />
		</div>
		</ol>
	</div> <!-- end of DIV main_content -->
	<div id="sub_main_content" >
<?php require('./include/sub_main_content.php'); ?>
	</div> <!-- end of DIV sub_main_content -->
</div> <!-- end of DIV body -->
<div id="footer">
<?php require('./include/footer.php'); ?>
</div> <!-- end of DIV footer -->
</body> </html>
