<div class="registration_form">
    <div style="display:none" class="toast-container position-fixed  top-10 end-0 p-3">
    <div id="liveToast" class=" toast" role="alert" aria-live="assertive" aria-atomic="true" style="display: flex; align-items: center; padding: 0 10px">
        <div style="width: 35px; ">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="white" class="bi bi-exclamation-octagon" viewBox="0 0 16 16">
            <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
        </svg>
        </div>
        <div style="font-size: 20px; color: #fff" class="toast-body">
        {message}
        </div>
    </div>
    </div>

    <div class="loading">
        <div class="loading-body">
            <div class="spinner-border text-primary" role="status"></div>
            <span>{loading_message}</span>
        </div>
    </div>  
    
        <div class="registration_header">
            <h1>
            <i>
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
            </i>    
            Yeni Kayıt
        </h1>
        <input type="hidden" value="n" name="fs">
        </div>
        <div class="registration_body">
            <form id="registration_form">
            <div class="registration_tab">
                <div class="tab active" data-tab="0">
                    <i class="tab-i con">1</i>
                    <span>Bilgilendirme</span>
                    <span class="tab-arrow">
                        <svg class="h-full w-full text-gray-300" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                            <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </div>
                <div class="tab " data-tab="1">
                    <i class="tab-icon">2</i>
                    <span>Kişi Bilgilerini Yazın</span>
                    <span class="tab-arrow">
                        <svg class="h-full w-full text-gray-300" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                            <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </div>
                <div class="tab" data-tab="2">
                    <i class="tab-icon">3</i>
                    <span>Onaylayın</span>
                    
                </div>
            </div>
            
            <div id="information-tab" class="tab-content active" data-tab="0">
                
                <div class="information-item">
                    <h2>Bilgi</h2>
                    <p>Dikkat edilmesi gereken hususlar</p>
                </div>
                <div class="information-item">
                        <i><svg style="width: 28px !important;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor" class="h-8 w-8">
                            <path d="M148 288h-40c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12zm108-12v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm96 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm-96 96v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm-96 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm192 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm96-260v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h48V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h128V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h48c26.5 0 48 21.5 48 48zm-48 346V160H48v298c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z"></path>
                        </svg>
                    </i>
                    <h3>Yaş Hesabı</h3>
                    <p>Yaş hesaplanırken doğum yılı esas alınır, ay ve gün hesaplanmaz</p>
                </div>
                <div class="information-item">
                    <i><svg style="width: 25px !important;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="currentColor" class="h-8 w-8">
                            <path d="M368 48h4c6.627 0 12-5.373 12-12V12c0-6.627-5.373-12-12-12H12C5.373 0 0 5.373 0 12v24c0 6.627 5.373 12 12 12h4c0 80.564 32.188 165.807 97.18 208C47.898 298.381 16 383.9 16 464h-4c-6.627 0-12 5.373-12 12v24c0 6.627 5.373 12 12 12h360c6.627 0 12-5.373 12-12v-24c0-6.627-5.373-12-12-12h-4c0-80.564-32.188-165.807-97.18-208C336.102 213.619 368 128.1 368 48zm-48 0c0 28.672-4.564 55.81-12.701 80H76.701C68.564 103.81 64 76.672 64 48h256zm-12.701 336H76.701C97.405 322.453 141.253 280 192 280s94.595 42.453 115.299 104z"></path>
                        </svg>
                    </i>
                    <h3>Başlangıç</h3>
                    <p>Fondan yararlanma hakkı kayıt tarihinden 3 ay sonra başlar.</p>
                </div>
                <div class="information-item">
                    <i><svg style="width: 32px !important;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor" >
                        <path d="M528 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h480c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zm0 400H48V80h480v352zM208 256c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm-89.6 128h179.2c12.4 0 22.4-8.6 22.4-19.2v-19.2c0-31.8-30.1-57.6-67.2-57.6-10.8 0-18.7 8-44.8 8-26.9 0-33.4-8-44.8-8-37.1 0-67.2 25.8-67.2 57.6v19.2c0 10.6 10 19.2 22.4 19.2zM360 320h112c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8H360c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8zm0-64h112c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8H360c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8zm0-64h112c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8H360c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8z"></path>
                    </svg>
                    </i>
                    <h3>Üye Kartı</h3>
                    <p> Üye Kartı sadece aile reisi adına düzenlenir.</p>
                </div>
                <div class="information-item">
                <i><svg style="width: 30px !important;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor" class="h-8 w-8">
                            <path d="M464 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zm-6 400H54a6 6 0 0 1-6-6V86a6 6 0 0 1 6-6h404a6 6 0 0 1 6 6v340a6 6 0 0 1-6 6zm-42-92v24c0 6.627-5.373 12-12 12H204c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h200c6.627 0 12 5.373 12 12zm0-96v24c0 6.627-5.373 12-12 12H204c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h200c6.627 0 12 5.373 12 12zm0-96v24c0 6.627-5.373 12-12 12H204c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h200c6.627 0 12 5.373 12 12zm-252 12c0 19.882-16.118 36-36 36s-36-16.118-36-36 16.118-36 36-36 36 16.118 36 36zm0 96c0 19.882-16.118 36-36 36s-36-16.118-36-36 16.118-36 36-36 36 16.118 36 36zm0 96c0 19.882-16.118 36-36 36s-36-16.118-36-36 16.118-36 36-36 36 16.118 36 36z"></path>
                        </svg>
                    </i>
                    <h3>Senelik Bağışlar</h3>
                    <p>Senede bir defa ödenmektedir. Sabit <strong>65 €</strong> dur.</p>
                    </div>
                <div class="information-item">
                <i><svg style="width: 30px !important;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor" class="h-8 w-8">
                            <path d="M464 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zm-6 400H54a6 6 0 0 1-6-6V86a6 6 0 0 1 6-6h404a6 6 0 0 1 6 6v340a6 6 0 0 1-6 6zm-42-92v24c0 6.627-5.373 12-12 12H204c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h200c6.627 0 12 5.373 12 12zm0-96v24c0 6.627-5.373 12-12 12H204c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h200c6.627 0 12 5.373 12 12zm0-96v24c0 6.627-5.373 12-12 12H204c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h200c6.627 0 12 5.373 12 12zm-252 12c0 19.882-16.118 36-36 36s-36-16.118-36-36 16.118-36 36-36 36 16.118 36 36zm0 96c0 19.882-16.118 36-36 36s-36-16.118-36-36 16.118-36 36-36 36 16.118 36 36zm0 96c0 19.882-16.118 36-36 36s-36-16.118-36-36 16.118-36 36-36 36 16.118 36 36z"></path>
                        </svg>
                    </i>
                    <h3>Giriş Bağışları</h3>
                    <p>Giriş bağışları her bir aile ferdi için geçerlidir ve bir kere ödenmektedir</p>
                    <div class="information-body">
                        <table class="table">
                            <thead>
                                <tr>
                                <th>Yaş Grubu</th>
                                <th>Giriş Ücreti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>0 - 19 yaş arası</th>
                                    <td>30 €</td>
                                </tr>
                                <tr>
                                    <th>20 - 29 yaş arası</th>
                                    <td>50 €</td>
                                </tr>
                                <tr>
                                    <th>30 - 39 yaş arası</th>
                                    <td>75 €</td>
                                </tr>
                                <tr>
                                    <th>40 - 44 yaş arası</th>
                                    <td>100 €</td>
                                </tr>
                                <tr>
                                    <th>45 - 49 yaş arası</th>
                                    <td>130 €</td>
                                </tr>
                                <tr>
                                    <th>50 - 54 yaş arası</th>
                                    <td>175 €</td>
                                </tr>
                                <tr>
                                    <th>55 - 59 yaş ve üzeri</th>
                                    <td>275 €</td>
                                </tr>
                                <tr>
                                    <th>60 - 64 yaş ve üzeri</th>
                                    <td>475 €</td>
                                </tr>
                                <tr>
                                    <th>65 - 69 yaş ve üzeri</th>
                                    <td>850 €</td>
                                </tr>
                                <tr>
                                    <th>70 - 74 yaş ve üzeri</th>
                                    <td>1000 €</td>
                                </tr>
                                <tr>
                                    <th>75 - 79 yaş ve üzeri</th>
                                    <td>1500 €</td>
                                </tr>
                                <tr>
                                    <th>80 yaş ve üzeri</th>
                                    <td>2250 €</td>
                                </tr>
                                
                            </tbody>
                        </table>
                        </div>
                </div>
                <div class="information-item">
                    <i>
                        <svg style="width: 35px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor" >
                            <path d="M568.54 167.33l-31.87-31.87c-9.94-9.94-26.07-9.94-36.01 0l-27.25 27.25 67.88 67.88 27.25-27.25c9.95-9.94 9.95-26.07 0-36.01zM329.06 306a63.974 63.974 0 0 0-16.26 27.11L297.57 384h-24.76c-4.28 0-8.12-2.38-10.16-6.5-11.97-23.86-46.28-30.34-66-14.17l-13.88-41.62c-3.28-9.81-12.44-16.41-22.78-16.41s-19.5 6.59-22.78 16.41L119 376.36c-1.5 4.58-5.78 7.64-10.59 7.64H96c-8.84 0-16 7.16-16 16s7.16 16 16 16h12.41c18.62 0 35.09-11.88 40.97-29.53L160 354.58l16.81 50.48a15.994 15.994 0 0 0 14.06 10.89c.38.03.75.05 1.12.05 6.03 0 11.59-3.41 14.31-8.86l7.66-15.33c2.78-5.59 7.94-6.19 10.03-6.19s7.25.59 10.19 6.53c7.38 14.7 22.19 23.84 38.62 23.84H336V464H47.99V48.09h159.97v103.98c0 13.3 10.7 23.99 24 23.99H336v78l48-47.58v-74.5c0-12.7-5.17-25-14.17-33.99L285.94 14.1c-9-9-21.2-14.1-33.89-14.1H47.99C21.5.1 0 21.6 0 48.09v415.92C0 490.5 21.5 512 47.99 512h287.94c26.5 0 48.07-21.5 48.07-47.99V388.8l134.66-135.58-67.88-67.88L329.06 306zM255.95 51.99l76.09 76.08h-76.09V51.99z"></path>
                        </svg>
                    </i>
                    <h3>Cenaze Fonu Yönergesi</h3>
                    <p>Başvurunuza başlamadan önce <a target="_blank" href="https://cenazefonu.hamele.org/hakkimizda/yardimlasma-fonu-yonergesi/">Cenaze Fonu Yönergesini</a> okumakla yükümlüsünüz.</p>
                </div>
                <div class="tab-content-bottom">
                    <span style="background: #06aedb !important " type="submit" class="btn btn-lg btn-primary go-to-form" data-tab="1">Yeni Kayıt 
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="tab-content   " data-tab="1">
                
                
                <div class="card" style="margin-bottom: 20px; padding :10px">
                
                    <div class="last-info-item total_price" style="display: flex; flex-direction: column; align-items: center" >
                        <svg  style="margin-bottom: 5px" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-basket" viewBox="0 0 16 16">
                            <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        <span style="color: #333">Toplam Giriş Ücreti</span>
                        
                        <div class="display-6"><span class="form_price">0</span> <small style="font-size: 25px;">€</small></div>
                        <small style="color: #888">+ yıllık aidat 65 €.</small>
                        <input type="hidden" name="form_price" />
                    </div>
                </div>
                <div class="card" style="padding :20px; margin-bottom: 20px">
                    <div class="tab-content-title">
                        <i>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                            <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
                        </svg>
                        </i>    
                    Aile Reisi Bilgileri</div>
                    <div class="mb-3">
                        <label for="householder_name" class="form-label">Adı <span>Gerekli</span></label>
                        <input placeholder="Buraya yazın" type="text" class="form-control" id="householder_name" name="householder_name">
                    </div>
                    <div class="mb-3">
                        <label for="householder_lastname" class="form-label">Soyadı <span>Gerekli</span></label>
                        <input placeholder="Buraya yazın" type="text" class="form-control" id="householder_lastname" name="householder_lastname">
                    </div>
                    <div class="mb-3">
                        <label for="householder_birthplace" class="form-label">Doğum Yeri / Ülke <span>Gerekli</span></label>
                        <input placeholder="Şehir / Ülke" type="text" class="form-control" id="householder_birthplace" name="householder_birthplace">
                    </div>

                    

                    <label for="householder_birthday" class="form-label">Doğum Tarih <span>Gerekli</span></label>
                    <div class="mb-3 birthday-selects">
                    
                        <div class="householder_birthday" id="householder_birthday">
                            <select name="householder_birthday" class="form-select birthday-select">
                                <option selected value="0">Gün</option>
                            </select>
                        </div>

                        <div class="householder_birthmonth">
                            <select name="householder_birthmonth" class="form-select month-select">
                                <option selected value="0">Ay</option>
                            </select>
                        </div>

                        <div class="householder_birthyear recalculate-price">
                            <select name="householder_birthyear" class="form-select year-select">
                                <option selected value="0">Yıl</option>
                            </select>
                        </div>

                    </div>
                        <div class="mb-3">
                            <label class="form-label">Cinsiyet <span>Gerekli</span></label>
                            <select name="householder_gender" class="form-select" >
                                <option selected value="0">Seçin</option>
                                <option value="woman">Kadın</option>
                                <option value="man">Erkek</option>
                            </select>
                        </div>
                    </div>
                    <div class="address_information">
                        <div class="card" style="padding :20px; margin-bottom: 20px">
                        <div class="tab-content-title">
                        <i><svg xmlns="http://www.w3.org/2000/svg" style="width: 28px !important" fill="currentColor" class="bi bi-house-add" viewBox="0 0 16 16">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h4a.5.5 0 1 0 0-1h-4a.5.5 0 0 1-.5-.5V7.207l5-5 6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"/>
                            <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 1 0 1 0v-1h1a.5.5 0 1 0 0-1h-1v-1a.5.5 0 0 0-.5-.5Z"/>
                        </svg>    </i>
                        Adres Bilgileri</div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail <span>Gerekli</span></label>
                            <input placeholder="Buraya yazın" name="email" type="text" class="form-control" id="email">
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Telefon <span>Gerekli</span></label>
                            <input placeholder="Buraya yazın" name="phone_number" type="text" class="form-control" id="phone_number">
                        </div>
                        <div class="mb-3">
                            <label style="margin-bottom: 0" for="phone" class="form-label">Fransa Adresi </label>
                            <p class="mb-3" style="font-size: 15px; color: #888">Posta yoluyla, mektupların size ulaşabileceği bir adres gerekiyor.</p>
                        </div>
                        
                        <div class="mb-3">
                            <label for="street" class="form-label">Cadde <span>Gerekli</span></label>
                            <input placeholder="Buraya yazın" name="street" type="text" class="form-control" id="street">
                        </div>
                        <div class="mb-3">
                            <label for="post_code" class="form-label">Posta Kodu <span>Gerekli</span></label>
                            <input placeholder="Buraya yazın" name="post_code" type="text" class="form-control" id="post_code">
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">Şehir <span>Gerekli</span></label>
                            <input placeholder="Buraya yazın" name="city" type="text" class="form-control" id="city">
                        </div>
                        <div class="mb-1">
                            <label style="margin-bottom: 0px;" for="turkey_address" class="form-label">Türkiye Adresi (Varsa)</label>
                            <p class="mb-3" style="font-size: 15px; color: #888">Varsa, Türkiye'de ikamet ettiğiniz bir adres.</p>
                            <textarea placeholder="Buraya yazın" style="resize: none" name="turkey_address" type="text" class="form-control" id="turkey_address"></textarea>
                        </div>
                    </div>

                    <div class="family_member_list card">
                    <div class="tab-content-title">
                            <i>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
                                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"></path>
                                <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"></path>
                            </svg>
                            </i>
                    Aile Ferdi</div>
                        
                    <div class="list-group member-list" style="margin: 10px">
                        
                        
                    </div>
                    </div>

                    

                    <div class="add-new-family-member" style="margin-top: 20px; display: flex; align-items:center">
                    <input value="no" class="btn-lg form-check-input ism" style="width: 50px; border-width: 3px; border-color: #ddd; height: 25px; cursor: pointer" name="ism" type="hidden" id="ism">
                    <input value="no" class="btn-lg form-check-input isset_member" style="width: 50px; border-width: 3px; border-color: #ddd; height: 25px; cursor: pointer" name="isset_member" type="hidden" id="isset_member">
                    <i style="margin-right: 10px">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25px" height="25px"  fill="#deb460" class="bi bi-person-add" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                            <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
                        </svg>
                    </i> 
            
            <span data-bs-toggle="modal" style="color: #06aedb !important" data-bs-target="#addNewMemeber" class="add-new-member" data-bs-toggle="modal">Yeni Aile Ferdi Ekle</span>
            </div>
                    </div>

                   <?php modal(false); ?>
                   
                        <div class="tab-content-bottom">
                            <span style="background: #06aedb !important " type="submit" class="display-information btn btn-lg btn-primary">Devam 
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                    
                </div>
                <div class="tab-content" data-tab="2">
                <div class="go-back go-to-form">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg> Geri 
                </div>

                <div class="tab-content-body">
                    
                <div class="information-dispay-template">
                    <div class="card" style="margin-bottom: 20px; padding :10px">
                    
                    <div class="last-info-item total_price" style="display: flex; flex-direction: column; align-items: center" >
                        <svg  style="margin-bottom: 5px" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-basket" viewBox="0 0 16 16">
                            <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        <span style="color: #333">Toplam Giriş Ücreti</span>
                        
                        <div class="display-6"><span class="form_price">0</span> <small style="font-size: 25px;">€</small></div>
                        <small style="color: #888">+ yıllık aidat 65 €.</small>
                        <input type="hidden" name="form_price" />
                    </div>
                
                </div>

                <div class="card" style="margin: 0px; padding :10px">
                    <div class="tab-content-title">
                        <i>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                            <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
                        </svg>
                        </i>    
                    Aile Reisi Bilgileri</div>

                    <div class="last-info-item">
                        <span>Adı / Soyadı</span>
                        <p><span class="householder_name"> </span> <span class="householder_lastname">{householder_lastname} </span> (<span class="householder_gender">{householder_gender}</span>) * <span class="badge bg-success text-white"><span style="color: white" class="  householder_age">{householder_age}</span> yaşında</span></p>
                    </div>
                    <div class="last-info-item">
                        <span>Doğum Tarihi</span>
                        <p><span class="householder_birthday">{householder_birthday}</span> / <span class="householder_birthmonth">{householder_birthmonth}</span> / <span class="householder_birthyear">{householder_birthyear}</span>  - <span class="householder_birthplace">{householder_birthplace}</span></p>
                    </div>
                </div>
                <div class="card family_member_information " style="margin: 20px 0; padding :10px">
                    <div class="tab-content-title">
                        <i>
                        <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                            <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
                        </svg>
                        </i>
                Aile Ferdi</div>

                <div class="list-group member-list"  data-no-delete="yes" style="margin: 10px">
                </div></div>
                <div class="card" style="margin:20px 0px; padding :10px">
                    <div class="tab-content-title">
                        <i><svg xmlns="http://www.w3.org/2000/svg" style="width: 28px !important" fill="currentColor" class="bi bi-house-add" viewBox="0 0 16 16">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h4a.5.5 0 1 0 0-1h-4a.5.5 0 0 1-.5-.5V7.207l5-5 6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"/>
                            <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 1 0 1 0v-1h1a.5.5 0 1 0 0-1h-1v-1a.5.5 0 0 0-.5-.5Z"/>
                        </svg>    </i>
                        Adres Bilgileri</div>
                    

                    
                        <div class="last-info-item">
                            <span>E-mail</span>
                            <p><span class="email">{email}</span></p>
                        </div>
                        <div class="last-info-item">
                            <span>Telefon</span>
                            <p><span class="phone_number">{phone_number}</span></p>
                        </div>
                        <div class="last-info-item">
                            <span>Cadde </span>
                            <p><span class="street">{street}</span></p>
                        </div>
                        <div class="last-info-item">
                            <span>Şehir  / Posta Kodu</span>
                            <p><span class="city">{city}</span> / <span class="post_code">{post_code}</span></p>
                        </div>
                        <div class="last-info-item">
                            <span>Türkiye Adresi</span>
                            <p><span class="turkey_address">{turkey_address}</span></p>
                        </div>
                    </div>

                </div>
            </div>

                <div class="aggrement">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="agreement-checkbox" name="agreement">
                        <label style="justify-content:inherit" for="agreement-checkbox"><a target="_blank" href="https://cenazefonu.hamele.org/hakkimizda/yardimlasma-fonu-yonergesi/" style="margin-right: 5px">Yönergeyi</a> okudum ve şartları kabul ediyorum. </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="registration-agreement" name="registration-agreement">
                        <label for="registration-agreement">Bilgilendirdiğim aile ferdlerini üye yapılmasını istiyorum.</label>
                    </div>
                </div>
                <div class="tab-content-bottom" style="margin-top: 30px">
                    
                    <button type="submit" class="btn btn-lg btn-success"> 
                        <svg  xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                            <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                            
                        </svg>
                        Onaylıyorum
                    </button>
                </div>
                </div>

                
            </div>
            </div>
            
            </form>
        </div>
</div>


<?php 

function family_member_form($is_hidden = false, $add_new_one = false)
{
    ?>
    
        <div class="family_member_form">
        <div class="card" style="padding :20px; margin-bottom: 20px">
        <div class="tab-content-title">
            <i>
            <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
            </svg>
            </i>
    Aile Ferdi</div>
            <div class="mb-3">
                <label for="member_name" class="form-label">Adı <span>Gerekli</span></label>
                <input placeholder="Buraya yazın" name="member_name" type="text" class="form-control" id="member_name">
            </div>
            <div class="mb-3">
                <label for="member_lastname" class="form-label">Soyadı <span>Gerekli</span></label>
                <input placeholder="Buraya yazın" type="text" class="form-control" id="member_lastname" name="member_lastname">
            </div>


            <div class="mb-3 member_birthday">
                <label for="member_birthday class="form-label">Doğum Tarihi <span>Gerekli</span></label>
            
                
            <div class=" birthday-selects">
            
                <div class="householder_birthday">
                    <select name="member_birthday" class="form-select birthday-select">
                        <option selected value="0">Gün</option>
                    </select>
                </div>

                <div class="member_birthmonth">
                    <select name="member_birthmonth" class="form-select month-select">
                        <option selected value="0">Ay</option>
                    </select>
                </div>

                <div class="member_birthyear">
                    <select name="member_birthyear" class="form-select year-select">
                        <option selected value="0">Yıl</option>
                    </select>
                </div>
            </div>
            <div class="member_gender mb-3" >
                <label style="margin-top: 20px" for="member_gender class="form-label">Cinsiyet <span>Gerekli</span></label>
                <select name="member_gender" class="form-select" id="member_gender">
                    <option selected value="0">Seçin</option>
                    <option value="woman">Kadın</option>
                    <option value="man">Erkek</option>
                </select>
            </div>
            <div class="member_intimacy mb-3">
                <label for="member_intimacy class="form-label">Yakınlık <span>Gerekli</span></label>
                <select name="member_intimacy" class="form-select" id="ferd_form_relationship" name="ferd[relationship]" required>
                    <option value="0">Seçiniz</option>
                    <option value="esi">Eşi</option>
                    <option value="cocugu">Çocuğu</option>
                </select>
            </div>
            </div>

            </div>
            
        

        
        </div> <!-- family member -->
    <?php
    }

?>

<?php 

    function modal()
    {
    ?>

    <!-- Modal -->
        <!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="addNewMemeber" tabindex="-1" aria-labelledby="addNewMemeberLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addNewMemeberLabel">Aile Ferdi Ekle</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?php family_member_form() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn close-modal btn-secondary" data-bs-dismiss="modal">Kapat</button>
        <button type="button" class="btn btn-primary add-member">Ekle</button>
      </div>
    </div>
  </div>
</div>
    <?php
    }

?>