<template>
    <div class="orders-content is-relative box">
        <div class="is-sticky close-orders-button">
            <o-button iconRightClass="regular" icon-right="close" @click="$emit('closeOrders')"></o-button>
        </div>
        <div class="is-flex is-justify-content-space-between is-flex-direction-column h-100">
            <div class="orders-container">
                <orders-row v-for="order in orders"
                              :key="order.id"
                              :can-control="user.id === order.customer.id || this.canControl"
                              :order="order"></orders-row>
            </div>
            <div class="orders-add-order-container w-100 is-flex is-sticky">
                <div class="w-100 is-radiusless">
                    <o-input v-model="requestedUrl"
                             required
                             clearable
                             class="is-radiusless"
                             placeholder="https://youtube.com/watch?v=dQw4w9WgXcQ"
                             type="url"
                             pattern="https://.*"
                             :useHtml5Validation="true"></o-input>
                </div>
                <div>
                    <o-button class="is-radiusless" icon-right="plus" @click=""></o-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import OrdersRow from "@/components/room/Orders/Row";
import {mapState} from "vuex";

export default {
    name: "Orders",
    components: {OrdersRow},
    props: {
        canControl: {
            type: Boolean,
            default: false
        },
    },
    computed: {
        ...mapState('auth', ['user'])
    },
    data() {
        return {
            requestedUrl: '',
            orders: [
                {
                    'video_url': 'https://Hotels.AndCastles.AndHouseboats.AndIgloos.AndTeepees.AndRiversideCabins.AndLakesideCabins.AndPondsideCabins.AndStreamAdjacentCabins.AndCabinsThatArentNearAnyBodiesOfWaterWhatsoever.AndLakeHouses.AndRegularHousesAndLodgesAndSkiLodgesAndAllThings.Ski/ChaletRelatedAndBoutiquesAnd5StarSuitesAndRetreatsAndBungalowsAndJungleBungalowsAndOtherKindaLessExcitingBungalowsAndCabanasAndOceansideCabanasAndSeaSideCabanasWhichSeemLikeTheSameThingAndBedAndBreakfastsAndJustBedsBecauseThoseAreKindOfARequirementInRoomsOfAnyKindInOurOpinionAndCottagesAndVacationHomesAndHostelsAndYouCanGetRewardedBasicallyEverywhereAndResortsAndGetawaysAndInnsAndHarborInnsAndVillasForGuysNamedJamieFromNorthEasternMiamiAndVillasForHumansNamedAnyOtherKindOfHumanNameAndTreehousesAndHousesNearTreesAndRanchesForPeopleWhoReallyLikeFarmAnimalsAndRanchesForPeopleWhoJustFeelKindOfSoSoAboutFarmAnimalsAndRanchesInGeneralAndCliffHousesAndRewardsAndYesWeAreSurprisedYouAreStillTypingAtThisPointButHeyWeStillHaveMoreAccomodationsSoWeWillJustKeepListingThemBroBroAndBeachGetawaysAndSnowyGetawaysAndThoseAreTheOnlyTwoKindsOfGetawaysAndMansionsAndLoftsAndFarmStaysAndFarmStayRetreatsSpecificallyInNewZealandBecauseNothingSaysLuxuryLikeAnExcessOfHayAndGoatNoisesAndIceHotelsAndIceCabinsAndIceLodgesAndHotelsWithBalconyCapabilitiesAndHotelsWithRooftopsBecauseEveryHotelNeedsARoofItIsKindOfJustLogisticalAndTimesharesAndCountryHomesAndPalazzinasAndYesWeKnowWhatPalazzinasAreDontActLikeWeDontWhoIsTheExpertHereAndPenthousesAndManorsAndStatelyManorsWhichFeelPrettySimilarAndTownhousesAndPalacesAndHousesAndCasasWhichAreHousesButInSpanishAndGuestHousesForWomenNamedTammyWhoLiveForAGreatDealAndRewardsForEveryoneElseWhoLikesAGreatDealAndAllTypesOfPlacesForPetsAndAllTypesOfPlacesForNotPetsAndThemedHotelsAndPirateHotelsAndFairyTaleHotelsAndHauntedHotelsAndHauntedMotelsOrToPutItAnotherWayMotelsAndYesWeAreStillGoingAndFamilyResortsAndPlacesNearGoatYogaAndPlacesWherePeopleHaveMusclesAndPlacesThatServeMelonBetweenTheHoursOf6And10AMAndHouseYachtsAndYachtClubsAndOtherThingsOnOrNearWaterAndDolphinMotelsInLowerSanDiegoAndAlsoYurts.com',
                    'customer': {
                        'id': 1,
                        'name': 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
                    },
                } ,{
                    'video_url': 'https://Hotels.AndCastles.AndHouseboats.AndIgloos.AndTeepees.AndRiversideCabins.AndLakesideCabins.AndPondsideCabins.AndStreamAdjacentCabins.AndCabinsThatArentNearAnyBodiesOfWaterWhatsoever.AndLakeHouses.AndRegularHousesAndLodgesAndSkiLodgesAndAllThings.Ski/ChaletRelatedAndBoutiquesAnd5StarSuitesAndRetreatsAndBungalowsAndJungleBungalowsAndOtherKindaLessExcitingBungalowsAndCabanasAndOceansideCabanasAndSeaSideCabanasWhichSeemLikeTheSameThingAndBedAndBreakfastsAndJustBedsBecauseThoseAreKindOfARequirementInRoomsOfAnyKindInOurOpinionAndCottagesAndVacationHomesAndHostelsAndYouCanGetRewardedBasicallyEverywhereAndResortsAndGetawaysAndInnsAndHarborInnsAndVillasForGuysNamedJamieFromNorthEasternMiamiAndVillasForHumansNamedAnyOtherKindOfHumanNameAndTreehousesAndHousesNearTreesAndRanchesForPeopleWhoReallyLikeFarmAnimalsAndRanchesForPeopleWhoJustFeelKindOfSoSoAboutFarmAnimalsAndRanchesInGeneralAndCliffHousesAndRewardsAndYesWeAreSurprisedYouAreStillTypingAtThisPointButHeyWeStillHaveMoreAccomodationsSoWeWillJustKeepListingThemBroBroAndBeachGetawaysAndSnowyGetawaysAndThoseAreTheOnlyTwoKindsOfGetawaysAndMansionsAndLoftsAndFarmStaysAndFarmStayRetreatsSpecificallyInNewZealandBecauseNothingSaysLuxuryLikeAnExcessOfHayAndGoatNoisesAndIceHotelsAndIceCabinsAndIceLodgesAndHotelsWithBalconyCapabilitiesAndHotelsWithRooftopsBecauseEveryHotelNeedsARoofItIsKindOfJustLogisticalAndTimesharesAndCountryHomesAndPalazzinasAndYesWeKnowWhatPalazzinasAreDontActLikeWeDontWhoIsTheExpertHereAndPenthousesAndManorsAndStatelyManorsWhichFeelPrettySimilarAndTownhousesAndPalacesAndHousesAndCasasWhichAreHousesButInSpanishAndGuestHousesForWomenNamedTammyWhoLiveForAGreatDealAndRewardsForEveryoneElseWhoLikesAGreatDealAndAllTypesOfPlacesForPetsAndAllTypesOfPlacesForNotPetsAndThemedHotelsAndPirateHotelsAndFairyTaleHotelsAndHauntedHotelsAndHauntedMotelsOrToPutItAnotherWayMotelsAndYesWeAreStillGoingAndFamilyResortsAndPlacesNearGoatYogaAndPlacesWherePeopleHaveMusclesAndPlacesThatServeMelonBetweenTheHoursOf6And10AMAndHouseYachtsAndYachtClubsAndOtherThingsOnOrNearWaterAndDolphinMotelsInLowerSanDiegoAndAlsoYurts.com',
                    'customer': {
                        'id': 2,
                        'name': 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
                    },
                },{
                    'video_url': 'http://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'customer': {
                        'id': 2,
                        'name': 'test',
                    },
                },{
                    'video_url': 'http://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'customer': {
                        'id': 1,
                        'name': 'еуые',
                    },
                },
            ]
        }
    },
}
</script>

<style scoped>
.orders-content {
    margin-top: 10px;
    padding: 0;
    height: 100%;
}
.orders-container {
    overflow-y: scroll;
    overflow-x: hidden;
}

.close-orders-button {
    height: 0;
    top: 0;
    opacity: 50%;
}

.close-orders-button:hover {
    opacity: 100%;
}

.orders-add-order-container {
    left: 0;
    height: 15%;
    z-index: 1;
}
</style>
