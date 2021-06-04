
<div class="py-12">

	<!---Student -->
	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
		<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
			
			<!---flash message -->
			@if (session()->has('message'))
			<div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
				<div class="flex">
					<div>
						<p class="text-sm">{{ session('message') }}</p>
					</div>
				</div>
			</div>
			@endif

			<button wire:click="create()" class="bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Create Student</button>
			
			@if($isModalOpen)
			
			@include('livewire.student.studentcreate')
			
			@endif


			<!---Student Data -->
			<table class="table-fixed w-full">
				
				<thead>
					<tr class="bg-gray-100">
					<th class="px-4 py-2 w-20">No.</th>
					<th class="px-4 py-2">Name</th>
					<th class="px-4 py-2">Age</th>
					<th class="px-4 py-2">Address</th>
					<th class="px-4 py-2">Percentage</th>
					<th class="px-4 py-2">School</th>
					<th class="px-4 py-2">Action</th>
					</tr>
				</thead>
				
				<tbody>

					@foreach($students as $student)
					<tr>
					<td class="border px-4 py-2">{{ $student->id }}</td>
					<td class="border px-4 py-2">{{ $student->name }}</td>
					<td class="border px-4 py-2">{{ $student->age}}</td>
					<td class="border px-4 py-2">{{ $student->address}}</td>
					<td class="border px-4 py-2">{{ $student->percentage}}</td>
					<td class="border px-4 py-2">{{ $student->school}}</td>
					<td class="border px-4 py-2">
						<button wire:click="edit({{ $student->id }})"
						class="bg-blue-500 text-white font-bold py-2 px-4 rounded mb-2" style="width:98px;">Edit</button>
						<button wire:click="delete({{ $student->id }})"
						class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
					</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			{{ $students->links() }}
		</div>
	</div>
</div>