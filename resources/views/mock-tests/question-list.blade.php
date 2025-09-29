@extends('master')

@section('contents')

<section class="w-100 bg-white px-2 overflow-hidden rounded">
    <!-- Section Header -->
    <div class="p-2 px-4 d-flex justify-content-between align-items-center" style="background-color: hsla(197, 66%, 81%, 0.879);color:#04070a">
        <h3 class="text-md m-0">All Questions</h3>

        <div class="flex gap-10">
            <form action="" method="GET" class="">
                <div class="dropdown rounded" style="width: 150px; background-color: hsla(199, 76%, 75%, 0.841);color:#04070a">
                    <a href="{{ route('mock-tests.question-setup.form') }}">
                        <p class="cursor-pointer bg-blue-800 text-center text-white p-2 rounded hover:bg-blue-600">
                            Create New
                        </p>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="">
        <div class="table-responsive mt-3">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-uppercase text-secondary small">ID</th>
                        <th scope="col" class="text-uppercase text-secondary small">Question</th>
                        <th scope="col" class="text-uppercase text-secondary small">Section</th>
                        <th scope="col" class="text-uppercase text-secondary small">Type</th>
                        <th scope="col" class="text-uppercase text-secondary small">Proficiency Level</th>
                        <th scope="col" class="text-uppercase text-secondary small">Bundle Type</th>
                        <th scope="col" class="text-uppercase text-secondary small">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questions as $question)
                    <tr>
                        <td>{{ $question->id }}</td>
                        <td>{!! $question->title !!}</td>
                        <td>{{ $question->section->title }}</td>
                        <td>{{ $question->type }}</td>
                        <td>{{ $question->proficiency_level }}</td>
                        <td>{{ $question->mockTestQuestionGroup->type }}</td>
                        <td>
                            <div class="flex gap-2">
                                <!-- Edit Button -->
                                <a href="{{ route('mock-tests.edit.question', $question->id) }}" 
                                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-green-500 text-white hover:bg-green-600 shadow-md transition">
                                    Edit
                                </a>
                                @if($question->mockTestQuestionGroup->type != "multiple")

                                <form action="{{ route('mock-tests.question.delete', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this question?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="px-4 py-2 rounded-xl text-sm font-medium bg-red-500 text-white hover:bg-red-600 shadow-md transition">
                                        Delete
                                    </button>
                                </form>

                                @else
                                <button type="submit" 
                                    class="px-4 py-2 rounded-xl text-sm font-medium bg-gray-300 text-gray-500 shadow-md transition cursor-not-allowed" disabled>
                                    Delete
                                </button>
                                @endif
                            </div>
                          
                        </td>
                        

                    </tr>
                    @endforeach
                </tbody>
            </table>
        <div class="mt-4 flex justify-center">
            {{ $questions->links() }}
        </div>
        
        </div>
    </div>


</section>

@endsection