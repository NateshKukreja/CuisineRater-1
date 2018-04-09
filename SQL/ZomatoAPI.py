import requests
import json
import pandas as pd
import random as rand
import math

class Api(object):
    def __init__(self, USER_KEY, host="https://developers.zomato.com/api/v2.1",
                 content_type='application/json'):
        self.host = host
        self.user_key = USER_KEY
        self.headers = {
            "User-agent": "curl/7.43.0",
            'Accept': content_type,
            'X-Zomato-API-Key': self.user_key
        }

    def get(self, endpoint, params):
        url = self.host + endpoint + "?"
        for k,v in params.items():
            url = url + "{}={}&".format(k, v)
        url = url.rstrip("&")
        response = requests.get(url, headers=self.headers)
        return response.json()
    

class Pyzomato(object):
    def __init__(self, USER_KEY):
        self.api = Api(USER_KEY)

    def getCategories(self):
        """
        Get a list of categories. List of all restaurants categorized under a particular restaurant
        type can be obtained using /Search API with Category ID as inputs
        """
        categories = self.api.get("/categories", {})
        return categories

    def getCityDetails(self, **kwargs):
        """
        :param q: query by city name
        :param lat: latitude
        :param lon: longitude
        :param city_ids: comma separated city_id values
        :param count: number of max results to display
        Find the Zomato ID and other details for a city . You can obtain the Zomato City ID in one of the following ways:
            -City Name in the Search Query - Returns list of cities matching the query
            -Using coordinates - Identifies the city details based on the coordinates of any location inside a city
        If you already know the Zomato City ID, this API can be used to get other details of the city.
        """
        params = {}
        available_keys = ["q", "lat", "lon", "city_ids", "count"]
        for key in available_keys:
            if key in kwargs:
                params[key] = kwargs[key]
        cities = self.api.get("/cities", params)
        return cities

    def getCollectionsViaCityId(self, city_id, **kwargs):
        """
        :param city_id: id of the city for which collections are needed
        :param lat: latitude
        :param lon: longitude
        :param count: number of max results to display
        Returns Zomato Restaurant Collections in a City. The location/City input can be provided in the following ways
         - Using Zomato City ID
         - Using coordinates of any location within a city
         - List of all restaurants listed in any particular Zomato Collection can be obtained using the '/search' API with Collection ID and Zomato City ID as the input
        """
        params = {"city_id": city_id}
        optional_params = ["lat", "lon", "count"]

        for key in optional_params:
            if key in kwargs:
                params[key] = kwargs[key]
        collections = self.api.get("/collections", params)
        return collections

    def getCuisines(self, city_id, **kwargs):
        """
        :param city_id: id of the city for which collections are needed
        :param lat: latitude
        :param lon: longitude
        Get a list of all cuisines of restaurants listed in a city.
        The location/city input can be provided in the following ways
          - Using Zomato City ID
          - Using coordinates of any location within a city
        List of all restaurants serving a particular cuisine can be obtained using
        '/search' API with cuisine ID and location details
        """
        params = {"city_id": city_id}
        optional_params = ["lat", "lon"]

        for key in optional_params:
            if key in kwargs:
                params[key] = kwargs[key]
        cuisines = self.api.get("/cuisines", params)
        return cuisines

    def getEstablishments(self, city_id, **kwargs):
        """
        :param city_id: id of the city for which collections are needed
        :param lat: latitude
        :param lon: longitude
        Get a list of restaurant types in a city. The location/City input can be provided in the following ways
        - Using Zomato City ID
        - Using coordinates of any location within a city
        List of all restaurants categorized under a particular restaurant type can obtained using
        /Search API with Establishment ID and location details as inputs
        """
        params = {"city_id": city_id}
        optional_params = ["lat", "lon"]

        for key in optional_params:
            if key in kwargs:
                params[key] = kwargs[key]
        establishments = self.api.get("/establishments", params)
        return establishments

    def getByGeocode(self, lan, lon):
        """
        :param lan: latitude
        :param lon: longitude
        Get Foodie and Nightlife Index, list of popular cuisines and nearby restaurants around the given coordinates
        """
        params = {"lat": lan, "lon": lon}
        response = self.api.get("/geocode", params)
        return response

    def getLocationDetails(self, entity_id, entity_type):
        """
        :param entity_id: location id obtained from locations api
        :param entity_type: location type obtained from locations api
        :return:
        Get Foodie Index, Nightlife Index, Top Cuisines and Best rated restaurants in a given location
        """
        params = {"entity_id": entity_id, "entity_type": entity_type}
        location_details = self.api.get("/location_details", params)
        return location_details

    def getLocations(self, query, **kwargs):
        """
        :param query: suggestion for location name
        :param lat: latitude
        :param lon: longitude
        :param count: number of max results to display
        :return: json response
        Search for Zomato locations by keyword. Provide coordinates to get better search results
        """
        params = {"query": query}
        optional_params = ["lat", "lon", "count"]

        for key in optional_params:
            if key in kwargs:
                params[key] = kwargs[key]
        locations = self.api.get("/locations", params)
        return locations

    def getDailyMenu(self, restaurant_id):
        """
        :param restaurant_id: id of restaurant whose details are requested
        :return: json response
        Get daily menu using Zomato restaurant ID.
        """
        params = {"res_id": restaurant_id}
        daily_menu = self.api.get("/dailymenu", params)
        return daily_menu

    def getRestaurantDetails(self, restaurant_id):
        """
        :param restaurant_id: id of restaurant whose details are requested
        :return: json response
        Get detailed restaurant information using Zomato restaurant ID.
        Partner Access is required to access photos and reviews.
        """
        params = {"res_id": restaurant_id}
        restaurant_details = self.api.get("/restaurant", params)
        return restaurant_details

    def getRestaurantReviews(self, restaurant_id, **kwargs):
        """
        :param restaurant_id: id of restaurant whose details are requested
        :param start: fetch results after this offset
        :param count: max number of results to retrieve
        :return: json response
        Get restaurant reviews using the Zomato restaurant ID
        """
        params = {"res_id": restaurant_id}
        optional_params = ["start", "count"]

        for key in optional_params:
            if key in kwargs:
                params[key] = kwargs[key]
        reviews = self.api.get("/reviews", params)
        return reviews

    def search(self, **kwargs):
        """
        :param entity_id: location id
        :param entity_type: location type (city, subzone, zone, lanmark, metro , group)
        :param q: search keyword
        :param start: fetch results after offset
        :param count: max number of results to display
        :param lat: latitude
        :param lon: longitude
        :param radius: radius around (lat,lon); to define search area, defined in meters(M)
        :param cuisines: list of cuisine id's separated by comma
        :param establishment_type: estblishment id obtained from establishments call
        :param collection_id: collection id obtained from collections call
        :param category: category ids obtained from categories call
        :param sort: sort restaurants by (cost, rating, real_distance)
        :param order: used with 'sort' parameter to define ascending / descending
        :return: json response
        The location input can be specified using Zomato location ID or coordinates. Cuisine / Establishment /
        Collection IDs can be obtained from respective api calls.
        Partner Access is required to access photos and reviews.
        Examples:
        - To search for 'Italian' restaurants in 'Manhattan, New York City',
        set cuisines = 55, entity_id = 94741 and entity_type = zone
        - To search for 'cafes' in 'Manhattan, New York City',
        set establishment_type = 1, entity_type = zone and entity_id = 94741
        - Get list of all restaurants in 'Trending this Week' collection in 'New York City' by using
        entity_id = 280, entity_type = city and collection_id = 1
        """
        params = {}
        available_params = [
            "entity_id", "entity_type", "q", "start",
            "count", "lat", "lon", "radius", "cuisines",
            "establishment_type", "collection_id",
            "category", "sort", "order"]

        for key in available_params:
            if key in kwargs:
                params[key] = kwargs[key]
        results = self.api.get("/search", params)
        return results
    
API_KEY = "d6ee90577fe8bc4d4c3eb5ff32d333e9"  
pyzomato = Pyzomato(API_KEY)
    
#done -- need to be added to file
def insertCuisineType(cuisineID):
    for k,v in cuisineID.items():   
        insertStatement = "INSERT INTO CUISINE(typeID, description) VALUES ({}, '{}');".format(k, v)
        
        file = open("Cuisine.txt", "a")
        file.write(insertStatement+"\n")
    
    print('Insert Cuisine Done!')
    print()
    
# -- get list of cuisines in Ottawa
ottawa = pd.DataFrame(pyzomato.getCuisines(295))
        
#print(json.dumps(ottawa, indent = 2))

cuisineID = {}
cID = [1, 4, 3, 401, 193, 5, 227,270,133,247,168,30]
for o in ottawa['cuisines']:
    if o['cuisine']['cuisine_id'] in cID:
        cuisineID[o['cuisine']['cuisine_id']] = o['cuisine']['cuisine_name']

#insertCuisineType(cuisineID)

def randomPhoneNumber():
    return rand.randint(1000000,9999999)

def randomManager():
    first_name = ['John', 'Jacob', 'Adam', 'Marcel', 'Daniel', 'Natesh', 'Aury']
    
    return first_name[rand.randint(0,len(first_name)-1)]

def randomDate():
    rYear = rand.randint(1980,2018)
    rMonth = rand.randint(1,12)
    rDay = rand.randint(1,28)
    return str(rYear)+'-'+str(rMonth)+'-'+str(rDay)
        
def insertRestaurant(pz, restID, cID, i):
        
    restCall = pz.getRestaurantDetails(restID)
    
    address = restCall['location']['address']
    firstOpen = randomDate()
    managerName = randomManager() + ' Smith'
    phoneNumber = '613-'+str(randomPhoneNumber())
    hourOpen = 630
    hourClose = 1100
    
    loc = open("Location.txt", "a")
    
    res = open("Restaurant.txt", "a")
    
    insertLocationStatement = "INSERT INTO LOCATION(LocationID, first_open, manager_name, phone_number, street_address, hour_open, hour_close, RestaurantID) VALUES ({}, '{}', '{}', '{}', '{}', {}, {}, {});".format(i, firstOpen, managerName, phoneNumber, address, hourOpen, hourClose, restID)
    
    loc.write(insertLocationStatement+"\n")
    
    insertRestaurantStatement = "INSERT INTO RESTAURANT(RestaurantID, Name, varType, Rating, URL) VALUES({},'{}',{},{},'{}');".format(restID, restCall['name'], cID, restCall['user_rating']['aggregate_rating'], restCall['url'])
    
    res.write(insertRestaurantStatement+"\n")
    
def insertRaterCredibility():
    
    file = open('RaterCred.txt', "a")
    
    for i in range(1, 21):
        insertStatement = "INSERT INTO RaterCredibility(type, description) VALUES({},'{}');".format(i, 'f'+'o'*i+'die')
        file.write(insertStatement+"\n")

restaurantIDs ={16665661:1,16663281:1,16666124:4,16664001:3,18535306:401,16665516:193,16663453:5,16664780:5,16665150:5,16665913:5,16663239:227,17840846:227,16663285:270,16664417:133,16664699:247,16664621:168,16663237:30,16663252:30}

rIDs = [16665661,16663281,16666124,16664001,18535306,16665516, 16663453,16664780,16665150,16665913,16663239,17840846,16663285,16664417,16664699,16664621,16663237,16663252]

#DONE
def insertRater(pyzomato, restID, cID):
    
    file = open("Rater.txt", "a")
    
    for r in review['user_reviews']:
        
        
        insertStatement = ("INSERT INTO Rater(UserID, email, name, signup_day, type, reputation, password) VALUES ({}, '{}@gmail.com','{}', '{}', {}, {},'{}');".format(r['review']['id'], r['review']['user']['name'].replace(' ',""), r['review']['user']['name'].upper(),'2017-01-01', cID,r['review']['user']['foodie_level_num'], 'password'))
        
        #file.write(insertStatement+"\n")
        
    #file.write("\n")    
    print('Insert Rater Credibility Done!')
    print()
            

#insertRaterCredibility()
print('done')
        
def randomRating(val):
    return rand.randint(0,val)
#in progress
def insertRating(pyzomato, restID):
    
    review = pd.DataFrame(pyzomato.getRestaurantReviews(restID))
    
    file = open("Rating.txt", "a")

    file = open("RatingItem.txt", "a")
    
    for r in review['user_reviews']:
        uID = r['review']['id']
        varDate = randomDate()
        rating = int(r['review']['rating'])
        comment = r['review']['review_text']

        insertStatement = "INSERT INTO RATING(UserID, varDate, Price, Food, Mood, Staff, Comments, RestaurantID) VALUES ({},'{}',{},{},{},{},'{}',{});".format(uID, varDate, rating, randomRating(rating), randomRating(rating), randomRating(rating), comment, restID)
        
        file.write(insertStatement+"\n")
    
        print('Insert Rating Done!')
    file.write("\n")
        
#important
i = 0
for k,v in restaurantIDs.items():
    i+=1
    #insertRestaurant(pyzomato, k, v,i)
    #insertRater(pyzomato,k,v)
    #insertRating(pyzomato, k)
    
foods = {
    1:'chicken breast',
    2:'pizza',
    3:'burger',
    4:'salad',
    5:'coffee',
    6:'milkshake',
    7:'kabob',
    8:'bubbletea',
    9:'sushi',
    10:'shawarma',
    11:'poutine',
    12:'candy',
    13:'big breakfast',
    14:'burrito',
    15:'beer'
}

itemRating = {
    1:'Complete garbage. Tastes terrible',
    2:'Pretty bad. No seasoning and did not enjoy it',
    3:'Decent but food was a little bland',
    4:'Great food but lacked a little sizzle',
    5:'Amazing, will come again!'
}


for i in range(0, 5):
    menu = open("Menu.txt", "a")
    itemReview = open("ItemReview.txt", "a")
    for rID in rIDs:
        c = rand.randint(1, len(cID)-1)
        f = rand.randint(1, 15)
        price = float(rand.randint(1, 99999)/100)
        insertMenuItem = "INSERT INTO MENUITEM (ItemID, name, varType, category, description, price, RestaurantID) VALUES({},'{}',{},'{}','{}',{},{});".format(f, foods[f], c, cuisineID[cID[c]], foods[f], price, rID)
        
        review = pd.DataFrame(pyzomato.getRestaurantReviews(rID))
        
        for r in review['user_reviews']:
            uID = r['review']['id']
            rating = int(math.ceil(r['review']['rating']))
            if rating == 0:
                rating = 1
            insertRatingItem = "INSERT INTO RatingItem (UserID, varDate, ItemID, rating, comments) VALUES({},'{}',{},{},'{}');".format(uID, randomDate(), f, rating, itemRating[rating])
            itemReview.write(insertRatingItem+"\n")
        menu.write(insertMenuItem+"\n")
    

print('done')
# -- IMPORTANT--
#insertCuisineType(cuisineID)

    
restaurantByCuisine={}
# -- IMPORTANT--

def cuisineIDCreation(pyzomato, cuisineID):
    for key in cuisineID:
        restaurantByCuisine[key] = []
        result = pd.DataFrame(pyzomato.search(cuisines = key, q = "Ottawa"))
        
        
        for r in result['restaurants']:
           
            print(r)
            restaurantByCuisine[key].append({'restaurant_id':r['restaurant']['R']['res_id'],'name':r['restaurant']['name'], 'cuisineID':key, 'url':r['restaurant']['url'], 'rating':r['restaurant']['user_rating']['aggregate_rating']})
            
            insertLocationStatement = "INSERT INTO LOCATION(first_open, manager_open, phone_number, street_address, hour_open, hour_close, RestaurantID) VALUES ({}, {}, {}, {}, {}, {}, {}, {})"
    
#    for k,v in restaurantByCuisine.items():
#        for value in v:
#            insertRater(pyzomato,value['restaurant_id'])

#cuisineIDCreation(pyzomato, cuisineID)


# -- IMPORTANT--
#insertRestaurant(restaurantByCuisine)
