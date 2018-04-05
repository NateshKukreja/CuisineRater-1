import requests
import json
import pandas as pd

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
    
API_KEY = "a5f1c6bcc5e82c4d868bd17ccc7c2860"  
pyzomato = Pyzomato(API_KEY)
    
#done -- need to be added to file
def insertCuisineType(cuisineID):
    for k,v in cuisineID.items():   
        print('INSERT INTO CUISINE(typeID, description) VALUES ({}, "{}")'.format(k, v))
        

def insertRestaurant(restaurantByCuisine):
        
    for k,v in restaurantByCuisine.items():
        for restaurants in v:
            print('INSERT INTO RESTAURANT(RestaurantID, Name, type, URL) VALUES ({}, {}, {}, {})'.format(restaurants['restaurant_id'], restaurants['name'], k, restaurants['url']))

#DONE
def insertRaterCredibility(pyzomato, restID):
    review = pd.DataFrame(pyzomato.getRestaurantReviews(restID))
    
    for r in review['user_reviews']:
        #print(r['review']['rating'])
        
        print(r['review']['id'])
        print(r['review']['user']['name'])
        print(r['review']['user']['foodie_level_num'])
        
        
        print('INSERT INTO Rater(UserID, email, name, signup_day, type, password) VALUES ({}, {}@gmail.com, {}, {}, {}, {})'.format(r['review']['id'], r['review']['user']['name'].replace(' ',""), r['review']['user']['name'].upper(), r['review']['review_time_friendly'] ,r['review']['user']['foodie_level_num'],'password'))
        
        print()
            
#in progress
def insertRating():
    UserID INTEGER,
    varDate DATE,
    Price DECIMAL(4,2),
    Food VARCHAR(255),
    Mood VARCHAR(255),
    Staff VARCHAR(255),
    Comments VARCHAR(255),
    RestaurantID INTEGER
    
    insertStatement = 'INSERT INTO RATING(UserID, varDate, Price, Food, Mood, Staff, Comments, RestaurantID) VALUES ()'
            
#print(json.dumps(pyzomato.getCategories(), indent = 2))

# -- get list of cuisines in Ottawa
ottawa = pd.DataFrame(pyzomato.getCuisines(295))
        
cuisineID={}

for t in ottawa['cuisines']:
    cuisineID[t['cuisine']['cuisine_id']] = t['cuisine']['cuisine_name']

    

# -- MAKE THIS CALL, UNCOMMENT
#insertCuisineType(cuisineID)



#print(json.dumps(cuisineID, indent = 2))

restaurantByCuisine = {}

#stores open_date (if available), phone, address, hour_open, hour_close, restaurant_ID
locationInfo = {}



'''
for key in cuisineID:
    restaurantByCuisine[key] = []
    result = pd.DataFrame(pyzomato.search(cuisines = key, q = "Ottawa"))
    for r in result['restaurants']:
        restaurantByCuisine[key].append({'restaurant_id':r['restaurant']['R']['res_id'],    'name':r['restaurant']['name'], 'cuisineID':key, 'url':r['restaurant']['url']})
        break
print(json.dumps(restaurantByCuisine, indent = 2))
'''

test =   {"451": [{
      "restaurant_id": 16664530,
      "name": "Perogies",
    "url":"perogies"
    }
  ],
  "308": [
    {
      "restaurant_id": 18282978,
      "name": "Asian Palace Ottawa",
        "url":"asian"
    }
  ],
  "99": [
    {
      "restaurant_id": 16663413,
      "name": "New Pho Bo Ga La",
        "url":"pho"
    }]}

#insertRestaurant(test)

insertRaterCredibility(pyzomato,16664530 )

#print(json.dumps(pyzomato.getRestaurantReviews(18282978), indent = 2))

'''
for k,v in temp.items():
    print(v['cuisine_id'])
    restaurantByCuisine[v['cuisine_id']] = []
    result = pd.DataFrame(pyzomato.search(cuisines = v['cuisine_id'], q = "Ottawa"))
    for r in result['restaurants']:
#    print(r['restaurant']['R']['res_id'])
#    print(r['restaurant']['name'])
#    print(r['restaurant']['url'])
#    print(r['restaurant']['location']['address'])
#    print(r['restaurant']['location']['city'])
#    print(r['restaurant']['location']['city_id'])
#    print(r['restaurant']['location']['zipcode'])
#    print(r['restaurant']['cuisines'])
        restaurantByCuisine[v['cuisine_id']].append({'restaurant_id':r['restaurant']['R']['res_id'], 'name':r['restaurant']['name']})

print(json.dumps(restaurantByCuisine, indent = 2))
'''
#collection_id is the cuisine

{
      "restaurant": {
        "R": {
          "res_id": 16665882
        },
        "apikey": "a5f1c6bcc5e82c4d868bd17ccc7c2860",
        "id": "16665882",
        "name": "Ginza Ramen",
        "url": "https://www.zomato.com/ottawa/ginza-ramen-centretown?utm_source=api_basic_user&utm_medium=api&utm_campaign=v2.1",
        "location": {
          "address": "280 Elgin Street, Ottawa K2P 1M2",
          "locality": "Centretown",
          "city": "Ottawa",
          "city_id": 295,
          "latitude": "45.4173576000",
          "longitude": "-75.6901093000",
          "zipcode": "K2P 1M2",
          "country_id": 37,
          "locality_verbose": "Centretown, Ottawa"
        },
        "switch_to_order_menu": 0,
        "cuisines": "Ramen, Sushi",
        "average_cost_for_two": 50,
        "price_range": 4,
        "currency": "$",
        "offers": [],
        "thumb": "https://b.zmtcdn.com/data/res_imagery/16665882_CHAIN_c236930c489ba2ee96c0d8744b7ecd83_c.jpeg?fit=around%7C200%3A200&crop=200%3A200%3B%2A%2C%2A",
        "user_rating": {
          "aggregate_rating": "3.4",
          "rating_text": "Average",
          "rating_color": "CDD614",
          "votes": "121"
        },
        "photos_url": "https://www.zomato.com/ottawa/ginza-ramen-centretown/photos?utm_source=api_basic_user&utm_medium=api&utm_campaign=v2.1#tabtop",
        "menu_url": "https://www.zomato.com/ottawa/ginza-ramen-centretown/menu?utm_source=api_basic_user&utm_medium=api&utm_campaign=v2.1&openSwipeBox=menu&showMinimal=1#tabtop",
        "featured_image": "https://b.zmtcdn.com/data/res_imagery/16665882_CHAIN_c236930c489ba2ee96c0d8744b7ecd83_c.jpeg",
        "has_online_delivery": 0,
        "is_delivering_now": 0,
        "deeplink": "zomato://restaurant/16665882",
        "has_table_booking": 0,
        "events_url": "https://www.zomato.com/ottawa/ginza-ramen-centretown/events#tabtop?utm_source=api_basic_user&utm_medium=api&utm_campaign=v2.1",
        "establishment_types": []
      }
}