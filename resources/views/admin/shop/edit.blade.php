@extends('layouts.admin.default')
@section("title","店铺信息编辑")
@section('content')

    <form action="" method="post" class="form-inline col-sm-8 control-label" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="text" class="form-control" placeholder="name" name="name" value="{{old("name",$user->name)}}" >
        </div>
        <br/>
        <div class="form-group">
            <input type="password" class="form-control"  placeholder="Password" name="password" value="{{old("email",$user->password)}}" >
        </div>
        <br/>
        <div class="form-group">
            <input type="email" class="form-control"  placeholder="email" name="email" value="{{old("email",$user->email)}}">
        </div>
        <br/>
        <div class="form-group">
            <input type="text" class="form-control"  placeholder="店铺名称" name="shop_name" value="{{old("shop_name",$shop->shop_name)}}">
        </div>
        <br/>
        <div class="form-group">
            店铺分类:<select name="shop_category_id" >
                @foreach($cates as $cate)
                    <option value="{{$cate->id}}" @if($shop->shop_category_id===$cate->id) selected @endif>{{$cate->name}}</option>
                @endforeach
            </select>
        </div>
        <br/>
        <div class="form-group">
            店铺图片:
            <input type="hidden" name="img" id="goods_img">
            <div id="uploader-demo">
                <!--用来存放item-->
                <div id="fileList" class="uploader-list"></div>
                <div id="filePicker">选择图片</div>
            </div>
        </div>
        <br/>
        <div class="checkbox">
            是否品牌:<label>
                <input type="checkbox" value="1" {{$shop->brand?"checked":""}} name="brand">是
            </label>
            <label>
                <input type="checkbox" value="0" {{$shop->brand?"":"checked"}} name="brand">否
            </label>
        </div>
        <br/>
        <div class="checkbox">
            是否准时送达:<label>
                <input type="checkbox" value="1" {{$shop->on_time?"checked":""}} name="on_time">是
            </label>
            <label>
                <input type="checkbox" value="0"{{$shop->on_time?"":"checked"}} name="on_time">否
            </label>
        </div>
        <br/>
        <div class="checkbox">
            是否蜂鸟配送:<label>
                <input type="checkbox" value="1" {{$shop->fengniao?"checked":""}} name="fengniao">是
            </label>
            <label>
                <input type="checkbox" value="0" {{$shop->fengniao?"":"checked"}} name="fengniao">否
            </label>
        </div>
        <br/>
        <div class="checkbox">
            是否保:<label>
                <input type="checkbox" value="1" {{$shop->bao?"checked":""}} name="bao" >是
            </label>
            <label>
                <input type="checkbox" value="0"{{$shop->bao?"":"checked"}} name="bao">否
            </label>
        </div>
        <br/>
        <div class="checkbox">
            是否票:<label>
                <input type="checkbox" value="1" {{$shop->piao?"checked":""}} name="piao">是
            </label>
            <label>
                <input type="checkbox" value="0"{{$shop->piao?"":"checked"}} name="piao">否
            </label>
        </div>
        <br/>
        <div class="checkbox">
            是否准:<label>
                <input type="checkbox" value="1"{{$shop->zhun?"checked":""}} name="zhun">是
            </label>
            <label>
                <input type="checkbox" value="0"{{$shop->zhun?"":"checked"}} name="zhun">否
            </label>
        </div>
        <br/>
        <div class="form-group">
            <input type="text" class="form-control"  placeholder="起送金额" name="start_send" value="{{old("start_send",$shop->start_send)}}">
        </div>
        <br/>
        <div class="form-group">
            <input type="text" class="form-control"  placeholder="配送费" name="send_cost" value="{{old("send_cost",$shop->send_cost)}}">
        </div>
        <br/>
        <button type="submit" class="btn btn-default">提交</button>
    </form>
@endsection
@section("js")
    <script>
        // 图片上传demo
        jQuery(function() {
            var $ = jQuery,
                $list = $('#fileList'),
                // 优化retina, 在retina下这个值是2
                ratio = window.devicePixelRatio || 1,

                // 缩略图大小
                thumbnailWidth = 100 * ratio,
                thumbnailHeight = 100 * ratio,

                // Web Uploader实例
                uploader;

            // 初始化Web Uploader
            uploader = WebUploader.create({

                // 自动上传。
                auto: true,
                formData:{
                    _token:'{{csrf_token()}}'
                },

                // swf文件路径
                swf: 'webuploader/Uploader.swf',

                // 文件接收服务端。
                server: '{{route('shop.upload')}}',

                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '#filePicker',

                // 只允许选择文件，可选。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                }
            });

            // 当有文件添加进来的时候
            uploader.on( 'fileQueued', function( file ) {
                var $li = $(
                    '<div id="' + file.id + '" class="file-item thumbnail">' +
                    '<img>' +
                    '<div class="info">' + file.name + '</div>' +
                    '</div>'
                    ),
                    $img = $li.find('img');

                $list.append( $li );

                // 创建缩略图
                uploader.makeThumb( file, function( error, src ) {
                    if ( error ) {
                        $img.replaceWith('<span>不能预览</span>');
                        return;
                    }

                    $img.attr( 'src', src );
                }, 100, 100 );
            });

            // 文件上传过程中创建进度条实时显示。
            uploader.on( 'uploadProgress', function( file, percentage ) {
                var $li = $( '#'+file.id ),
                    $percent = $li.find('.progress span');

                // 避免重复创建
                if ( !$percent.length ) {
                    $percent = $('<p class="progress"><span></span></p>')
                        .appendTo( $li )
                        .find('span');
                }

                $percent.css( 'width', percentage * 100 + '%' );
            });

            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on( 'uploadSuccess', function( file ,date) {
                $( '#'+file.id ).addClass('upload-state-done');
                $("#goods_img").val(date.url)
            });

            // 文件上传失败，现实上传出错。
            uploader.on( 'uploadError', function( file ) {
                var $li = $( '#'+file.id ),
                    $error = $li.find('div.error');

                // 避免重复创建
                if ( !$error.length ) {
                    $error = $('<div class="error"></div>').appendTo( $li );
                }

                $error.text('上传失败');
            });
            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on( 'uploadComplete', function( file ) {
                $( '#'+file.id ).find('.progress').remove();
            });
        });
    </script>
@endsection