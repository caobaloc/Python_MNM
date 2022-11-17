from django.shortcuts import render
from store.models import Product
from store.models import Category

def home(request):
    products = Product.objects.all().filter(is_available=True)
    categories = Category.objects.all()
    context = {
        'products': products,
        'links': categories,
    }
    return render(request, 'home.html', context=context)

def about(request):
    return render(request, 'sport247/about.html')

def contact(request):
    return render(request, 'sport247/contact.html')
