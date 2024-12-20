<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>マイページ</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/my_page.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
  <header>
    <div class="menu-button">
      <button id="btn_menu8" class="btn_menu"><span></span></button>
    </div>
    <div class="rese">
      <a>Rese</a>
    </div>
  </header>

  <div id="nav-overlay" class="nav-overlay"></div>
  <nav id="nav-menu" class="header__nav">
    <a href="/my_page" class="square_btn"></a>
    <a href="/" class="home">Home</a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="logout">Logout</button>
    </form>
    <a href="/my_page" class="mypage">Mypage</a>
  </nav>

  <div class="container mt-5 pt-5">
    <div class="user text-center mt-5">
      <p class="userName">{{ Auth::user()->name }} さん</p>
    </div>

    <div class="contain mt-5 d-flex">
      <div class="reserve card p-3 me-3">
        <p class="title">予約状況</p>
        @if($reservations->isEmpty())
        <p>予約がありません。</p>
        @else
        @php $count = 1; @endphp
        @foreach ($reservations as $reservation)
        <div class="reservation-item p-3 mb-3 shadow-sm">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="d-flex align-items-center">
              <i class="fa-regular fa-clock"></i>
              <p class="reservation-number ms-2">予約{{ $count++ }}</p>
            </div>
            <div>
              <i class="fa-regular fa-pen-to-square text-warning edit-reservation" data-reservation-id="{{ $reservation->id }}" data-date="{{ $reservation->date }}" data-time="{{ $reservation->time }}" data-people="{{ $reservation->people }}" data-bs-toggle="modal" data-bs-target="#editReservationModal"></i>
              <i class="fa-regular fa-circle-xmark text-danger delete-reservation" data-reservation-id="{{ $reservation->id }}"></i>
              <button class="btn btn-primary rate-reservation ms-2" data-reservation-id="{{ $reservation->id }}" data-bs-toggle="modal" data-bs-target="#rateReservationModal">評価</button>
              <button class="btn btn-success pay-now ms-2" data-reservation-id="{{ $reservation->id }}" data-people="{{ $reservation->people }}" data-bs-toggle="modal" data-bs-target="#paymentModal">事前決済</button>
              <button class="btn btn-info generate-qr ms-2" data-reservation-id="{{ $reservation->id }}" data-bs-toggle="modal" data-bs-target="#qrCodeModal">QRコード生成</button>
            </div>
          </div>
          <p class="shop_name text-white">店舗名: {{ $reservation->shop->name ?? json_decode($reservation->shop)->name }}</p>
          <p class="Date text-white">日付: {{ $reservation->date }}</p>
          <p class="Time text-white">時間: {{ $reservation->time }}</p>
          <p class="Number text-white">人数: {{ $reservation->people }}人</p>
        </div>
        @endforeach
        @endif
      </div>

      <div class="likes card p-3 flex-grow-1">
        <p class="title">お気に入り店舗</p>
        @if($favorites->isEmpty())
        <p>お気に入り店舗がありません。</p>
        @else
        <div class="row">
          @foreach ($favorites as $favorite)
          @if($favorite->shop)
          <div class="col-md-6 mb-3 favorite-card" data-shop-id="{{ $favorite->shop->id }}">
            <div class="card shadow-sm">
              <img class="card-img-top" src="{{ asset($favorite->shop->photo) }}" alt="{{ $favorite->shop->name }}">
              <div class="card-body">
                <div class="details">
                  <p class="shop_name">{{ $favorite->shop->name }}</p>
                </div>
                <div class="details-row d-flex">
                  <p class="area">#{{ $favorite->shop->area->name }}</p>
                  <p class="genre ms-2">#{{ $favorite->shop->genre->name }}</p>
                </div>
                <div class="details_3">
                  <button class="btn btn-primary" onclick="window.location.href='/detail/{{ $favorite->shop->id }}'">詳しく見る</button>
                  <i class="{{ $favorite->shop->is_favorite ? 'fas' : 'far' }} fa-heart favorite-heart text-danger float-end" data-shop-id="{{ $favorite->shop->id }}"></i>
                </div>
              </div>
            </div>
          </div>
          @endif
          @endforeach
        </div>
        @endif
      </div>
    </div>
  </div>

  <div class="modal fade" id="editReservationModal" tabindex="-1" aria-labelledby="editReservationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editReservationModalLabel">予約を編集</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editReservationForm">
            @csrf
            <input type="hidden" name="reservation_id" id="reservation_id">
            <div class="mb-3">
              <label for="edit_date" class="form-label">日付</label>
              <input type="date" class="form-control" id="edit_date" name="date" required>
            </div>
            <div class="mb-3">
              <label for="edit_time" class="form-label">時間</label>
              <input type="time" class="form-control" id="edit_time" name="time" required>
            </div>
            <div class="mb-3">
              <label for="edit_people" class="form-label">人数</label>
              <input type="number" class="form-control" id="edit_people" name="people" required>
            </div>
            <button type="submit" class="btn btn-primary">保存</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="rateReservationModal" tabindex="-1" aria-labelledby="rateReservationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rateReservationModalLabel">店舗を評価</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="rateReservationForm">
            @csrf
            <input type="hidden" name="reservation_id" id="rate_reservation_id">
            <div class="mb-3">
              <label for="rating" class="form-label">評価</label>
              <select class="form-select" id="rating" name="rating" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="comment" class="form-label">コメント</label>
              <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">保存</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="paymentModalLabel">事前決済</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="total-amount" class="mb-3"></div>
          <div id="card-element"></div>
          <div class="mb-3">
            <label for="postal-code" class="form-label">郵便番号</label>
            <input type="text" id="postal-code" class="form-control" maxlength="7" pattern="\d{7}" required>
          </div>
          <button id="submit" class="btn btn-primary mt-3">
            <div class="spinner hidden" id="spinner"></div>
            <span id="button-text">支払いを完了する</span>
          </button>
          <p id="payment-message" class="hidden"></p>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="qrCodeModalLabel">QRコード</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <img id="qrCodeImage" src="" alt="QR Code">
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      const favoriteHearts = document.querySelectorAll('.favorite-heart');
      const deleteButtons = document.querySelectorAll('.delete-reservation');
      const btnMenu = document.getElementById('btn_menu8');
      const navMenu = document.getElementById('nav-menu');
      const navOverlay = document.getElementById('nav-overlay');
      const navItems = document.querySelectorAll('.header__nav a');
      const generateQrButtons = document.querySelectorAll('.generate-qr');

      const editButtons = document.querySelectorAll('.edit-reservation');
      const editForm = document.getElementById('editReservationForm');
      const rateButtons = document.querySelectorAll('.rate-reservation');
      const rateForm = document.getElementById('rateReservationForm');
      const payButtons = document.querySelectorAll('.pay-now');
      const qrButtons = document.querySelectorAll('.generate-qr');

      editButtons.forEach(button => {
        button.addEventListener('click', function() {
          const reservationId = button.dataset.reservationId;
          const date = button.dataset.date;
          const time = button.dataset.time;
          const people = button.dataset.people;

          document.getElementById('reservation_id').value = reservationId;
          document.getElementById('edit_date').value = date;
          document.getElementById('edit_time').value = time;
          document.getElementById('edit_people').value = people;
        });
      });

      editForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(editForm);
        const reservationId = formData.get('reservation_id');
        const data = {
          date: formData.get('date'),
          time: formData.get('time'),
          people: formData.get('people')
        };

        fetch(`/update-reservation/${reservationId}`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrfToken,
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
          })
          .then(response => {
            if (response.ok) {
              const modal = bootstrap.Modal.getInstance(document.getElementById('editReservationModal'));
              modal.hide();
              location.reload();
            } else {
              console.error('更新に失敗しました');
            }
          })
          .catch(error => {
            console.error('エラーが発生しました', error);
          });
      });

      rateButtons.forEach(button => {
        button.addEventListener('click', function() {
          const reservationId = button.dataset.reservationId;
          document.getElementById('rate_reservation_id').value = reservationId;
        });
      });

      rateForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(rateForm);
        const reservationId = formData.get('reservation_id');
        const data = {
          rating: formData.get('rating'),
          comment: formData.get('comment')
        };

        fetch(`/rate-reservation/${reservationId}`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrfToken,
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
          })
          .then(response => {
            if (response.ok) {
              const modal = bootstrap.Modal.getInstance(document.getElementById('rateReservationModal'));
              modal.hide();
              location.reload();
            } else {
              console.error('評価の保存に失敗しました');
            }
          })
          .catch(error => {
            console.error('エラーが発生しました', error);
          });
      });

      deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
          const reservationId = button.dataset.reservationId;
          const confirmation = confirm("本当に削除しますか？");

          if (confirmation) {
            fetch(`/delete-reservation/${reservationId}`, {
                method: 'DELETE',
                headers: {
                  'X-CSRF-TOKEN': csrfToken,
                }
              })
              .then(response => {
                if (response.ok) {
                  button.closest('.reservation-item').remove();
                } else {
                  console.error('削除に失敗しました');
                }
              })
              .catch(error => {
                console.error('エラーが発生しました', error);
              });
          }
        });
      });

      favoriteHearts.forEach((heart) => {
        heart.addEventListener('click', (event) => {
          event.currentTarget.classList.toggle('fas');
          event.currentTarget.classList.toggle('far');
          event.currentTarget.classList.toggle('text-danger');

          const shopId = event.currentTarget.getAttribute('data-shop-id');
          fetch(`/favorite/toggle/${shopId}`, {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
              }
            }).then(response => response.json())
            .then(data => {
              if (data.status === 'success') {
                const card = document.querySelector(`.favorite-card[data-shop-id="${shopId}"]`);
                if (card) {
                  card.remove();
                }
              }
            });
        });
      });

      payButtons.forEach(button => {
        button.addEventListener('click', function() {
          const people = button.dataset.people;
          const totalAmount = people * 3000;
          document.getElementById('total-amount').textContent = `合計金額: ${totalAmount}円`;
          fetch('/create-payment-intent', {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                amount: totalAmount
              })
            })
            .then(response => response.json())
            .then(data => {
              const clientSecret = data.clientSecret;
              const stripe = Stripe('pk_test_51PZ492BYDKsUv1YRl7SQM09noBQtTjOZfXkf33jWrhkyjYGQ0HeCCTLus3qSIxKdjppn1tt67v0nk9sQXhTOJIVX00ITWBPCaH');
              const elements = stripe.elements();
              const card = elements.create('card');
              card.mount('#card-element');

              document.getElementById('submit').addEventListener('click', function() {
                const postalCode = document.getElementById('postal-code').value;
                if (!/^\d{7}$/.test(postalCode)) {
                  alert('郵便番号は7桁の数字で入力してください。');
                  return;
                }

                stripe.confirmCardPayment(clientSecret, {
                  payment_method: {
                    card: card,
                    billing_details: {
                      name: '{{ Auth::user()->name }}',
                      address: {
                        postal_code: postalCode
                      }
                    },
                  }
                }).then(function(result) {
                  if (result.error) {
                    console.error(result.error.message);
                  } else {
                    if (result.paymentIntent.status === 'succeeded') {
                      alert('支払いが完了しました');
                      const modal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
                      modal.hide();
                    }
                  }
                });
              });
            });
        });
      });

      qrButtons.forEach(button => {
        button.addEventListener('click', function() {
          const reservationId = button.dataset.reservationId;
          fetch(`/generate-qr-code/${reservationId}`, {
              method: 'GET',
              headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
              }
            })
            .then(response => response.json())
            .then(data => {
              if (data.status === 'success') {
                const qrCodeImage = document.createElement('img');
                qrCodeImage.src = data.qrCodeUrl;
                qrCodeImage.alt = 'QR Code';
                const qrCodeContainer = document.getElementById('qr-code-container');
                qrCodeContainer.innerHTML = '';
                qrCodeContainer.appendChild(qrCodeImage);
              } else {
                const qrCodeMessage = document.getElementById('qr-code-message');
                qrCodeMessage.textContent = 'QRコードの生成に失敗しました';
                qrCodeMessage.classList.remove('hidden');
              }
            })
            .catch(error => {
              console.error('QRコードの生成に失敗しました', error);
            });
        });
      });

      generateQrButtons.forEach(button => {
        button.addEventListener('click', function() {
          const reservationId = button.dataset.reservationId;
          fetch(`/generate-qr-code/${reservationId}`)
            .then(response => response.json())
            .then(data => {
              if (data.status === 'success') {
                document.getElementById('qrCodeImage').src = data.qrCodeUrl;
              } else {
                console.error('QRコードの生成に失敗しました', data.message);
              }
            })
            .catch(error => {
              console.error('QRコードの生成に失敗しました', error);
            });
        });
      });

      btnMenu.addEventListener('click', function() {
        navMenu.classList.toggle('active');
        navOverlay.classList.toggle('active');
        document.body.classList.toggle('no-scroll');
      });

      navOverlay.addEventListener('click', function() {
        navMenu.classList.remove('active');
        navOverlay.classList.remove('active');
        document.body.classList.remove('no-scroll');
      });

      navItems.forEach((item) => {
        item.addEventListener('click', function() {
          navMenu.classList.remove('active');
          navOverlay.classList.remove('active');
          document.body.classList.remove('no-scroll');
        });
      });
    });
  </script>

</body>

</html>