<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Utility Job - 夢の仕事を見つけよう</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#D64545',
                        secondary: '#1A1A1A',
                        accent: '#E6B8B8',
                    },
                    fontFamily: {
                        sans: ['Noto Sans JP', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        .bg-shoji {
            background-color: #F5F5F5;
            background-image: linear-gradient(#E5E5E5 1px, transparent 1px),
                              linear-gradient(90deg, #E5E5E5 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="font-sans bg-shoji text-secondary">
    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-primary">
                    <a href="/" class="flex items-center">
                        <svg class="w-8 h-8 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                            <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                        </svg>
                        Utility Job
                    </a>
                </div>
                <div class="hidden md:flex space-x-6">
                    <a href="#" class="text-secondary hover:text-primary transition-colors duration-300">仕事を探す</a>
                    <a href="#" class="text-secondary hover:text-primary transition-colors duration-300">企業一覧</a>
                    <a href="#" class="text-secondary hover:text-primary transition-colors duration-300">キャリアアドバイス</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-secondary transition-colors duration-300">ダッシュボード</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-secondary transition-colors duration-300">ダッシュボード</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-secondary hover:text-primary transition-colors duration-300">ログイン</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-secondary transition-colors duration-300">新規登録</a>
                        @endif
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-primary to-accent text-white py-20">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">夢の仕事を見つけよう</h1>
                <p class="text-xl mb-8">トップ企業の何千もの求人があなたを待っています</p>
                <form class="max-w-3xl mx-auto flex flex-col md:flex-row gap-4">
                    <input type="text" placeholder="職種またはキーワード" class="flex-grow px-4 py-3 rounded-md text-secondary focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300">
                    <input type="text" placeholder="勤務地" class="flex-grow px-4 py-3 rounded-md text-secondary focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300">
                    <button type="submit" class="bg-secondary text-white px-6 py-3 rounded-md font-semibold hover:bg-primary transition-colors duration-300">検索</button>
                </form>
            </div>
        </section>

        <!-- Featured Jobs Section -->
        <section class="py-16">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold text-center mb-12">注目の求人</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @for ($i = 1; $i <= 6; $i++)
                        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                            <div class="flex items-center mb-4">
                                <img src="/placeholder.svg?height=50&width=50" alt="企業ロゴ" class="w-12 h-12 rounded-full mr-4">
                                <div>
                                    <h3 class="font-semibold text-lg">ソフトウェアエンジニア</h3>
                                    <p class="text-gray-600">テックコープ株式会社</p>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-4">最先端の技術を使用して革新的な製品を開発するソフトウェアエンジニアを募集しています。チームワークを重視し、成長機会が豊富です。</p>
                            <div class="flex justify-between items-center">
                                <span class="text-primary font-semibold">年収 800万円 - 1200万円</span>
                                <span class="text-gray-500">東京都</span>
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="text-center mt-12">
                    <a href="#" class="bg-primary text-white px-6 py-3 rounded-md font-semibold hover:bg-secondary transition-colors duration-300">すべての求人を見る</a>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="bg-white py-16">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold text-center mb-12">ご利用の流れ</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">1. 仕事を探す</h3>
                        <p class="text-gray-600">豊富な求人の中からあなたのスキルと経験にマッチする仕事を見つけましょう。</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">2. オンライン応募</h3>
                        <p class="text-gray-600">数クリックで簡単に応募できます。効率的なプロセスで複数の求人に応募可能です。</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">3. 採用</h3>
                        <p class="text-gray-600">企業とつながり、面接を成功させ、夢の仕事を手に入れましょう。私たちがサポートします。</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="py-16 bg-accent">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold text-center mb-12">利用者の声</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex items-center mb-4">
                                <img src="/placeholder.svg?height=50&width=50" alt="ユーザーアバター" class="w-12 h-12 rounded-full mr-4">
                                <div>
                                    <h3 class="font-semibold">田中 太郎</h3>
                                    <p class="text-gray-600">ソフトウェア開発者</p>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-4">「ジョブハブのおかげで、素晴らしい会社で夢の仕事を見つけることができました。私のスキルと興味に合った仕事を簡単に検索し、応募することができました。」</p>
                            <div class="flex text-primary">
                                @for ($j = 1; $j <= 5; $j++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1  1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-primary text-white py-16">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold mb-4">就職活動を始める準備はできましたか？</h2>
                <p class="text-xl mb-8">ジョブハブで理想のキャリアを見つけた何千人もの求職者に加わりましょう</p>
                <a href="{{ route('register') }}" class="bg-white text-primary px-8 py-3 rounded-md font-semibold hover:bg-secondary hover:text-white transition-colors duration-300">アカウントを作成する</a>
            </div>
        </section>
    </main>

    <footer class="bg-secondary text-white py-8">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">ジョブハブ</h3>
                    <p class="text-gray-400">夢の仕事を簡単に見つけられます。ジョブハブは、優秀な人材とトップ企業をつなぎます。</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">クイックリンク</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">会社概要</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">お問い合わせ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">よくある質問</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">プライバシーポリシー</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">求職者の方へ</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">求人を探す</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">キャリアアドバイス</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">履歴書のヒント</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">求人アラート</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">企業の方へ</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">求人を掲載する</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">人材を探す</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">料金プラン</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">採用ソリューション</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} ジョブハブ. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>