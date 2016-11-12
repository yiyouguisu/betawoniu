<include file="Public:head"  />
  <div class="header center z-index112 pr f18 fix-head">
    房东介绍
    <div class="head_go pa">
        <a href="javascript:history.go(-1)">
            <img src="__IMG__/go.jpg">
        </a><span>&nbsp;</span>
    </div>
  </div>
  <div class="container" style="margin-top:6rem;padding-top:20px;">
      <div class="land_a center">
          <div class="land_a1">
              <img src="{$data.head}" style="width:80px;height:80px;border-radius:50%">
          </div>
          <div class="land_a2 home_d1 margin_05 f16">{$data.nickname}</div>
          <div class="home_d2 margin_05">
              <div class="home_d3 vertical mr_4">
                  <img src="__IMG__/home_a1.png">实名认证</div>
              <div class="home_d3 vertical">
                  <img src="__IMG__/home_a2.png">个人房东</div>
          </div>
      </div>
      <div class="home_e center">
          <div class="home_e1">
              <div class="home_e2">{$data.onlinereply}<span>%</span>
              </div>
              <div class="home_e3">在线回复率:</div>
          </div>
          <div class="home_e1">
              <div class="home_e2">{$data.evaluationconfirm}<span>分钟</span>
              </div>
              <div class="home_e3">评价确认时间:</div>
          </div>
          <div class="home_e1">
              <div class="home_e2">{$data.orderconfirm}<span>%</span>
              </div>
              <div class="home_e3">订单接受率:</div>
          </div>
      </div>
      <div class="home_f">
          <div class="home_f1 center">房东资料</div>
          <div class="home_b">
              <div class="home_b_box">
                  <div class="home_b1">性别 : 
                  <span>
                    <if condition="$data.sex eq 1">男<else />女</if>
                  </span>
                  </div>
                  <div class="home_b1">年龄 : <span>{$data.birthday}</span>
                  </div>
              </div>
              <div class="home_b_box">
                  <div class="home_b1">星座 : <span>{$data.constellation}</span>
                  </div>
                  <div class="home_b1">血型 : <span>{$data.bloodtype}</span>
                  </div>
              </div>
              <div class="home_b_box">
                  <div class="home_b1">学历 : <span>{$data.education}</span>
                  </div>
                  <div class="home_b1">所在地 : <span>{$areas}</span>
                  </div>
              </div>
              <div class="home_b_box" style="border:0">
                  <div class="home_b1">故乡 : <span>山东</span>
                  </div>
              </div>
          </div>
      </div>
      <div class="home_f">
        <div class="home_f1 center">房东的美宿</div>
        <volist name="data.hostel" id="vo">
          <div class="land_c back_fff f14">
            <a href="{:U('Hostel/show')}?id={$vo.id}">
              <div class="land_d pr f0">
                <div class="land_e vertical">
                  <img src="{$vo.thumb}">
                </div>
                <div class="land_f vertical" style="padding-top:10px;">
                  <div class="land_f1 f16">{$vo.title}</div>
                  <div class="land_f3 pa f0">
                      <div class="land_money f20">{$vo.evaluation}<span>分</span></div>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </volist>
      </div>
  </div>
</body>
</html>
