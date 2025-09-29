@extends('master')

@section('contents')

<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
  <div class="flex h-[calc(100vh-50px)] bg-gray-100 overflow-clip">
    <!-- Sidebar (User List) -->
    <div class="w-[450px] bg-white border-r border-gray-300 flex flex-col h-[calc(100vh-50px)]">
      <!-- Header -->
      <div class="p-4 flex items-center border-b border-gray-200 justify-between">
        <h2 class="font-semibold text-gray-700 text-lg">Candidates</h2>
      </div>

      <!-- Search -->
      {{-- <div class="px-4 py-2">
            <input
              type="text"
              placeholder="Search candidate..."
              class="w-full px-4 py-2 text-sm bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>
      
          <div class="flex gap-2 mx-4 my-4 text-sm">
            <button class="px-5 py-1.5 rounded-2xl bg-indigo-300">All</button>
            <button class="px-5 py-1.5 rounded-2xl bg-gray-300">Unread</button>
          </div>
       --}}
      <!-- Candidate List -->
      <ul class="flex-1 overflow-y-auto">
        @foreach ($conversations as $conversation)
        <li class="px-4 py-3 flex items-center gap-3 hover:bg-gray-100 cursor-pointer border-b border-gray-100">
          <!-- Candidate Photo -->
          <img
            src="{{ $conversation->photo ?? asset('imagePH.png') }}"
            class="w-12 h-12 rounded-full"
            alt="User" />
          <div class="flex-1 min-w-0">
            <a href="{{route('support.view',$conversation->candidate_id)}}">
              <div class="flex justify-between items-center">
                <span class="font-medium text-gray-900">{{ $conversation->first_name }} {{ $conversation->last_name }}</span>
                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($conversation->last_message_created_at)->diffForHumans() }}</span>
              </div>
              <!-- Display the last message -->
              <p class="text-sm text-gray-500 truncate">
                {!! $conversation->is_seen ? $conversation->last_message_body : '<p style="color:rgb(0, 0, 0); font-weight:bold; font-size:14px">' . $conversation->last_message_body . '</p style="text-color:red">' !!}
              </p>
            </a>
          </div>
        </li>
        @endforeach
      </ul>
    </div>

    <!-- Chat Section -->
    <div class="w-[calc(100%-450px)] h-[calc(100vh-70px)] flex flex-col gap-2 p-4">

      @if(count($singleConversation)>0)
      <div class="flex gap-3 items-center bg-white py-2 px-6 rounded shadow">
        <img
          src="{{ $singleConversation[0]->candidate->photo ?? asset('imagePH.png') }}"
          class="w-12 h-12 rounded-full"
          alt="User" />
        <div class="flex-1 min-w-0">
          <a href="{{route('support.view',$singleConversation[0]->candidate->id)}}">
            <div class="flex justify-between items-center">
              <!-- Concatenate candidate's name -->
              <span class="font-medium text-gray-900">{{ $singleConversation[0]->candidate->first_name }} {{ $singleConversation[0]->candidate->last_name }}</span>
              <!-- Last message timestamp -->

            </div>

          </a>
        </div>
      </div>
      @endif



      <div
        class="bg-white border border-gray-300 rounded-lg shadow-lg flex flex-col h-[78vh]">
        <!-- Chat Messages -->
        <div  x-init="$el.scrollTop = $el.scrollHeight" id="chatMessages" class="flex-1 p-4 space-y-4 overflow-y-auto">
          <!-- Example: No messages -->

          <!-- Example: User message -->

          @if(count($singleConversation)>0)
          @foreach($singleConversation as $message)

          @if($message->user_id)
          <div class="flex items-end justify-end w-full">
            <div
              title="10:30 AM"
              class="relative px-4 py-2 rounded-2xl max-w-xs sm:max-w-sm text-sm break-words shadow-md bg-blue-600 text-white rounded-br-none">
              {{$message->body}}
            </div>
          </div>
          @else

          <div class="flex items-start justify-start w-full">
            <div
              title="10:31 AM"
              class="relative px-4 py-2 rounded-2xl max-w-xs sm:max-w-sm text-sm break-words shadow-md bg-gray-200 text-gray-800 rounded-bl-none">
              {{$message->body}}
            </div>
          </div>
          @endif
          @endforeach
          @else
          <div
            id="noMessages"
            class="text-center text-sm text-gray-400 mt-5 w-full">
            No messages yet. Start the conversation.
          </div>

          @endif

        </div>

        <!-- Chat Input -->
        @if(count($singleConversation)>0)
        <form action="{{route('support.send.messages')}}" method="post" enctype="multipart/form-data"
          id="chatForm"
          class="border-t border-gray-300 px-4 py-3 flex gap-2 items-center w-full">
          @csrf
          <input type="hidden" value="{{$singleConversation[0]->candidate_id}}" name="candidate_id">
          <input
            id="chatInput"
            type="text"
            name="message"
            placeholder="Type your message..."
            class="flex-1 px-4 py-2 border border-gray-300 rounded-full focus:outline-none text-sm bg-white" />
          <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-2 h-10 w-10 sm:w-[100px] flex items-center justify-center gap-1 rounded-full transition">
            <span class="text-lg">➤</span>
            <span class="hidden sm:block">Send</span>
          </button>
        </form>
        @endif

      </div>
    </div>
  </div>
</body>

<script>
  function scrollToBottom() {
    const chatMessages = document.getElementById("chatMessages");
    if (chatMessages) {
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }
  }

  // Scroll when page loads
  window.addEventListener("load", scrollToBottom);

  // Scroll again after form submit (new message)
  document.getElementById("chatForm")?.addEventListener("submit", () => {
    setTimeout(scrollToBottom, 200); // wait for message render
  });
</script>

</html>

@endsection