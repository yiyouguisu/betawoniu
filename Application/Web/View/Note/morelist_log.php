<volist name="data" id="vo">
    <li class="item">
        <a href="javascript:;">
            <div class="hidden activity1">
                <span class="fl">
                    大转盘
                    <eq name="vo['rid']" value="1">一等奖</eq>
                      <eq name="vo['rid']" value="2">二等奖</eq>
                     <eq name="vo['rid']" value="3">三等奖</eq>
                      <eq name="vo['rid']" value="4">四等奖</eq>
                     <eq name="vo['rid']" value="5">五等奖</eq>
                </span>
                <i class="fr" style="background:none;width: auto;color: #333;">抽奖日期：{$vo.inputtime|date="Y-m-d",###}</i>
            </div>
            <div class="activity2">
                <p>奖品内容：
                    <eq name="vo['rid']" value="1">全额抵扣券</eq>
                      <eq name="vo['rid']" value="2">5折抵扣券</eq>
                     <eq name="vo['rid']" value="3">8折抵扣券</eq>
                      <eq name="vo['rid']" value="4">投票抵扣券</eq>
                     <eq name="vo['rid']" value="5">邀请投票抵扣券</eq>
                    一张,
                请在有效期（{$vo.validity_starttime|date="Y-m-d",###}至{$vo.validity_endtime|date="Y-m-d",###}）内使用</p>
            </div>
        </a>
    </li>
</volist>