@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto px-4 py-8">

	{{-- 詳細へ戻る --}}
	<div class="mb-6">
		<a
			href="{{ route('tasks.show', $task->id) }}"
			class="btn btn-ghost gap-2"
		>
			<svg
				xmlns="http://www.w3.org/2000/svg"
				fill="none"
				viewBox="0 0 24 24"
				stroke-width="2"
				stroke="currentColor"
				class="size-5"
			>
				<path
					stroke-linecap="round"
					stroke-linejoin="round"
					d="m15 18-6-6 6-6"
				/>
			</svg>
			詳細へ戻る
		</a>
	</div>
	{{-- タスク編集 --}}
	<div class="card bg-base-100 shadow-sm border border-base-300">
		<div class="card-body">
			<h1 class="card-title text-2xl mb-4">
				タスク編集
			</h1>
			<form
				method="POST"
				action="{{ route('tasks.update', $task->id) }}"
			>
				@csrf
				@method('PUT')
				<div class="mb-6">
					{{-- ステータス・カラー --}}
					<div class="flex flex-col sm:flex-row gap-4">
						{{-- ステータス --}}
						<div class="w-full sm:w-56">
							<label for="status" class="label">
								<span class="label-text">ステータス</span>
							</label>
							<input
								type="text"
								id="status"
								name="status"
								value="{{ old('status', $task->status) }}"
								class="input input-bordered w-full"
								maxlength="10"
								required
							/>
						</div>
						{{-- カラー --}}
						<div>
							<div class="label">
								<span class="label-text">カラー</span>
							</div>
							<div class="flex items-center gap-4 h-10">
								{{-- 指定なし --}}
								<label class="flex items-center gap-2 cursor-pointer">
									<input
										type="radio"
										name="color"
										value=""
										class="radio"
										{{ old('color', $task->color) === null || old('color', $task->color) === '' ? 'checked' : '' }}
									/>
									<span>なし</span>
								</label>
								{{-- 青 --}}
								<label class="cursor-pointer" title="青">
									<input
										type="radio"
										name="color"
										value="#3b82f6"
										class="radio radio-info"
										{{ old('color', $task->color) === '#3b82f6' ? 'checked' : '' }}
									/>
								</label>
								{{-- 緑 --}}
								<label class="cursor-pointer" title="緑">
									<input
										type="radio"
										name="color"
										value="#22c55e"
										class="radio radio-success"
										{{ old('color', $task->color) === '#22c55e' ? 'checked' : '' }}
									/>
								</label>
								{{-- 黄 --}}
								<label class="cursor-pointer" title="黄">
									<input
										type="radio"
										name="color"
										value="#eab308"
										class="radio radio-warning"
										{{ old('color', $task->color) === '#eab308' ? 'checked' : '' }}
									/>
								</label>
								{{-- 赤 --}}
								<label class="cursor-pointer" title="赤">
									<input
										type="radio"
										name="color"
										value="#ef4444"
										class="radio radio-error"
										{{ old('color', $task->color) === '#ef4444' ? 'checked' : '' }}
									/>
								</label>
							</div>
						</div>
					</div>
					{{-- タスク内容 --}}
					<div class="mt-4">
						<label for="content" class="label">
							<span class="label-text">内容</span>
						</label>
						<input
							type="text"
							id="content"
							name="content"
							value="{{ old('content', $task->content) }}"
							class="input input-bordered w-full"
							required
						/>
					</div>
				</div>
				{{-- 更新ボタン --}}
				<div class="flex justify-end">
					<button
						type="submit"
						class="btn btn-primary"
					>
						<svg
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="2"
							stroke="currentColor"
							class="size-5"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								d="M4.5 12.75 10.5 18.75 19.5 5.25"
							/>
						</svg>
						更新する
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection