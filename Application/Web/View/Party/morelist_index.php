<volist name='party' id='vo'>
  <div class="recom_list pr">
      <div class="recom_a pr">
          <a href="{:U('Web/Party/show',array('id'=>$vo['id']))}">
            <img src="{$vo.thumb}" style="width: 100%;height: 60vw;">
          </a>
          <a href="{:U('Web/Member/memberHome',array('id'=>$vo['uid']))}">
            <div class="recom_d pa"><img src="{$vo.head}" style="width:60px;height:60px"></div>
          </a>
      </div>
      <div class="recom_c pa">
        <div class="recom_gg collect <if condition='$vo.iscollect eq 1'>recom_c_cut</if>" data-id="{$vo.id}" data-uid="{$uid}" <if condition="$vo.iscollect eq 1" > data-collect="1" <else/> data-collect="0" </if> ></div>
      </div>
      <div class="recom_e">
         <div class="land_f1 recom_e1 f16">{:str_cut($vo['title'],12)}</div>
         <div class="recom_k">
                  <div class="land_font ft12">
                      <span>时间：</span> {$vo.starttime|date='Y-m-d',###} 至{$vo.endtime|date='Y-m-d',###}      
                  </div> 
                  <div class="land_font ft12">
                      <span>地点：</span>{:getarea($vo['area'])}{$vo.address}      
                  </div> 
        </div>
        <div class="recom_s f16">
            已参与：
            <span id="sapn">
                <volist name="vo['joinlist']" id="v">
                    <img src='{$v.head}' style="width:40px;height:40px;">
                </volist>
            </span>
            <em>({$vo.joinnum|default="0"}人)</em>
        </div>
      </div>
  </div>
</volist>
