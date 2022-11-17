from django.urls import path, include
from django.contrib import admin
from django.conf import settings
from django.conf.urls.static import static

from . import views

urlpatterns = [
    path('admin/', admin.site.urls),
    path('', views.home, name='home'),

    path('carts/', include('carts.urls')),
    path('store/', include('store.urls')),
    path('orders/', include('orders.urls')),
    # path('categories/', include('categories.urls')),
    path('accounts/', include('accounts.urls')),

    path('about/', views.about, name='about'),
    path('contact/', views.contact, name='contact'),

] + static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)
