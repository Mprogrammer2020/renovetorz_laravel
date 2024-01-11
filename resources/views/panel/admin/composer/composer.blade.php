@extends('panel.layout.app')
@section('title', __('Subscriptions and Packs'))

@section('content')
   <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="card bg-[#F2F1FD] !shadow-sm dark:bg-[#14171C] dark:shadow-black">
                <div class="card-body md:p-10">
                    <div class="row">
                        <form id="composer_type_form" class="workbook-form">
                            <div class="relative mb-3">
                            <h3>{{__('Composer')}}</h>
                            </div>
                            <hr>
                            <div class="flex flex-wrap justify-between gap-3 mt-8">
                                <div class="grow">
                                 <input type="checkbox" name="Documents" id="documents" value="1" {{ $getComposerData[0]['status'] == '1' ? 'checked' : '' }}>
                                 <span> {{__('Documents')}}</span>
                                </div>
                                <div class="grow">
                                   <input type="checkbox" name="AI Writer" id="ai_writer" value="1" {{ $getComposerData[1]['status'] == '1' ? 'checked' : '' }}>
                                 <span> {{__('AI Writer')}}</span>
                                </div>
                                <div class="grow">
                                    <input type="checkbox" name="AI Image" id="ai_image" value="1" {{ $getComposerData[2]['status'] == '1' ? 'checked' : '' }}>
                                 <span> {{__('AI Image')}}</span>
                                </div>
                                <div class="grow">
                                    <input type="checkbox" name="AI Chat" id="ai_chat" value="1" {{ $getComposerData[3]['status'] == '1' ? 'checked' : '' }}>
                                 <span> {{__('AI Chat')}}</span>
                                </div>
                                <div class="grow">
                                 <input type="checkbox" name="AI Code" id="ai_code" value="1" {{ $getComposerData[4]['status'] == '1' ? 'checked' : '' }}>
                                 <span> {{__('AI Code')}}</span>
                                </div>
                                <div class="grow">
                                   <input type="checkbox" name="AI Speech to Text" id="ai_speech_to_text" value="1" {{ $getComposerData[5]['status'] == '1' ? 'checked' : '' }}>
                                 <span> {{__('AI Speech to Text')}}</span>
                                </div>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary" id="composer_type_button">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/assets/js/panel/composer.js"></script>
    
@endsection
