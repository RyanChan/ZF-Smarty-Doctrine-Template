{include file="header.tpl" title="404"}
<div class="container clearfix">

    <div class="sixteen columns bottom">
        <h1 class="page-title">404 / <span class="gray2">找不到頁面</span><span class="line"></span></h1>
    </div>    <!-- Page Title -->

    <div id="description">
        <div class="sixteen columns">
            <div class="description bottom">
                <h1 class="big">404</h1>
                <p class="bottom-2">
                    你訪問的頁面並不存在
                </p>
                <p>{$this->message}</p>

                {if $this->exception}
                    <p>{$this->exception->getMessage()}</p>
                    <p>{$this->exception->getTraceAsString()}</p>
                {/if}
                <a href="index.html" class="button medium black">返回</a>
                <a href="{geturl module="default" controller="index" action="index"}" class="button medium black">主頁</a>
            </div>
        </div>
    </div><!-- End description -->

</div><!-- <<< End Container >>> -->
{include file="footer.tpl"}