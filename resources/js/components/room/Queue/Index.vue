<template>
    <div class="queue-content is-relative box">
        <div class="is-sticky close-queue-button">
            <o-button iconRightClass="regular" icon-right="close" @click="$emit('closeQueue')"></o-button>
        </div>
        <div class="is-flex is-justify-content-space-between is-flex-direction-column h-100">
            <div>
                <queue-column v-for="order in orders"
                              :key="order.id"
                              :can-control="user.id === order.customer.id"
                              :order="order"></queue-column>
            </div>
            <div class="queue-add-order-container w-100 is-flex is-sticky">
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
import QueueColumn from "@/components/room/Queue/Column";
import {mapState} from "vuex";

export default {
    name: "Queue",
    components: {QueueColumn},
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
.queue-content {
    margin-top: 10px;
    padding: 0;
    height: calc(100% - 10px);
    overflow-y: scroll;
    overflow-x: hidden;
}

.close-queue-button {
    height: 0;
    top: 0;
    opacity: 50%;
}

.close-queue-button:hover {
    opacity: 100%;
}

.queue-add-order-container {
    bottom: -3px;
    left: 0;
    height: 15%;
    z-index: 1;
}
</style>
