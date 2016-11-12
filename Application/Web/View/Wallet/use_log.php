<include file="public:head" />
<div class="header center z-index112 pr f18 fix-head">
  钱包使用记录
  <div class="head_go pa">
    <a href="javascript:history.back();">
      <img src="__IMG__/go.jpg">
    </a>
  </div>
</div>
<div class="container" style="margin-top:6rem">
   <div class="land_c">
    <volist name="logs" id="log">
        <div class="mer_list">
             <div class="mer_left fl">
                  <div class="mer_a1">{$log.remark}</div>
                  <div class="mer_a2">余额 :{$log.total}</div> 
             </div>
             <div class="mer_right fr">
                  <div class="mer_a3">2016-5-1</div>
                  <div class="mer_a4">
                    <eq name="log.dcflag" value="1">+<else />-</eq>{$log.money}
                  </div>
             </div>
        </div>    
    </volist>
   </div> 
</div>
</body>
</html>
