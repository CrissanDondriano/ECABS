<div class="bg-white border-end" id="sidebar-wrapper">
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{route('home')}}" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none sidebar-heading">
            <img class="" src="{!! url('assets/images/CABS.png') !!}" alt="" width="45" height="45">
            <span class="h2 fw-bold mt-2 px-1 logo-name sidebar-text logo-text">eCABS</span>
        </a>
        <a class="sidebar-close p-4 fw-bold" style="cursor: pointer"><i class="fa-solid fa-x fa-xl" style="color: #000000;"></i></a>
    </div>
   
    <div class="list-group list-group-flush px-2">
        <div class="p-1 mt-3">
            <a class="sidebar-button p-3" href="{{route('home')}}" data-toggle="tooltip" title="Overview">
                <img class="" src="{!! url('assets/icons/overview.png') !!}" alt="" width="25" height="25">
                <span class="sidebar-text px-1">Overview</span>
            </a>
        </div>

        <div class="p-1 mt-3">
            <a class="sidebar-button p-3" href="#" id="openReservationModal" data-toggle="tooltip" title="Make your Reservation">
                <img class="" src="{!! url('assets/icons/booking.png') !!}" alt="" width="25" height="25">
                <span class="sidebar-text px-1">Make Reservation</span>
            </a>
        </div>
        <div class="p-1 mt-3">
            <a class="sidebar-button p-3" href="{{route('modifyReservation')}}" data-toggle="tooltip" title="Modify your Reservation">
                <img class="" src="{!! url('assets/icons/calendar.png') !!}" alt="" width="25" height="25">
                <span class="sidebar-text px-1">Manage Reservation</span>
            </a>
        </div>
        <div class="p-1 mt-3">
            <a class="sidebar-button p-3" href="{{route('viewReservation')}}" data-toggle="tooltip" title="View your Reservation List">
                <img class="" src="{!! url('assets/icons/view-reservation.png') !!}" alt="" width="25" height="25">
                <span class="sidebar-text px-1">View Reservation List</span>
            </a>
        </div>
        
        <div class="p-1 mt-3">
            <a class="sidebar-button p-3" href="{{route('helpDesk')}}" data-toggle="tooltip" title="Frequency Answer Question">
                <img class="" src="{!! url('assets/icons/help-desk.png') !!}" alt="" width="25" height="25">
                <span class="sidebar-text px-1">FAQ</span>
            </a>
        </div>
    </div>
</div>

<div class="modal fade" id="reservationModal" tabindex="-1" role="dialog" aria-labelledby="reservationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold" id="reservationModalLabel">Terms and Conditions</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto" style=" max-height: 40rem;">
                <p class="fw-bold">Please read and agree to the following terms and conditions before proceeding with the reservation:</p>
                <ol>
                    <li class="fw-bold">Cabs Rules and Regulations in Using the Multi-Sports Hall.</li>
                    <ul class="italic">
                        <li>All scheduled activities of the City Schools Division of Cabuyao every fiscal year should be communicated to the CABS Administrator for proper scheduling of the dates for reservation of the Multi-Sports Hall. These reservations shall be prioritized by the CABS administrator.</li>
                        <li>All requests for Multi-Sports Hall use including equipment rental require a trained Audio-Visual technician for the operation of lighting and/or sound system. Generally, the assignment of the technician includes set-up and time to remove the equipment. Specific lighting and sound needs must be communicated to the technician at least one week prior to the event.</li>
                        <li>The Multi-Sports Hall should be left in such a fashion that will allow for the daytime use of the hall by the staff and future renters.</li>   
                        <li>Under no circumstances should sets or stage pieces be attached to the floor. It is the responsibility of the user to remove all tape and/or other markings from the floor, seats, doors and stage area. Only gaffers’ tape should be used for markings. Gaffers tape is supplied by the renter. Masking and Duct tape will not be allowed in the Multi-Sports Hall at any time. Building of sets for performances will not be permitted in the hall area. Arrangements should be made in advance for an area for this purpose.</li>
                        <li>Food and drink are allowed in the Multi-Sports Hall provided that the user ensures that policy on cleanliness and orderliness is adhered to. Arrangements for food and beverage in locations other than the hall must be made in advance. No alcoholic beverages or controlled substances are allowed inside hall.
                        </li>
                        <li>Multi-Sports Hall systems (stage rigging, lighting, audio & video) may only be operated by individuals approved by the CABS management.
                        </li>
                        <li>Props, backdrops, etc. may only be hung in a safe manner according to the intended use of stage rigging and sets. No objects are to be fastened to the stage curtains. No objects are to be hung from the sprinkler pipes. No objects are to be fastened to the stage floor or walls. Only personnel that are trained and approved by CABS management to use audio, video, and/or lighting equipment will be authorized to use the hall equipment. 
                        </li>
                        <li>The CABS administrator/authorized representative has absolute authority ensure the safety of all scenery, props, equipment, etc., and to require the removal of the unsafe material or modifications to satisfy safety needs. </li>
                        <li>Stage area is to be left clear by the renter after the activity.</li>
                        <li>All equipment, props, etc., owned by the renter must be removed from the premises the evening of the last performance, unless other arrangements have been made with the CABS management. Storage space in the hall is extremely limited.</li>
                        <li>No entrances, exits, corridors, or other means of egress will be blocked or restricted in any fashion as this will endanger those in attendance in the event of an emergency. </li>
                        <li>Scenery and decorations that will be installed on the stage must be fire safe.
                        </li>
                        <li>The time specified in the contract shall be strictly enforced. Exceptions may be made only by the CABS administrator/authorized representative.
                        </li>
                        <li>Wiring for special effects in performances on the stage must receive approval from the local Fire Department.</li>
                        <li>Smoking is strictly prohibited in the hall, lobby area or inn CABS premises.
                        </li>
                    </ul>
                    <li class="fw-bold pt-3">Cabs Rules and Regulations in Using the Swimming Pool.</li>
                    <ul class="italic">
                        <li>No one is allowed in the Swimming pool without the presence of an CABS lifeguard.</li>
                        <li>All guests must shower thoroughly for 20 seconds to remove all sand, lotions, and similar products before entering pool or spa and after reapplication of said products.
                        </li>
                        <li>No bikes, scooters, skateboards, or non ADA needs transportation devices of any kind are allowed in the pool area. </li>
                        <li>Food, beverages, and gum are not allowed inside the pool area.</li>
                        <li>No glass containers of any kind are allowed in the pool area. </li>
                        <li>Prolonged underwater swimming or breath holding is prohibited.</li>
                        <li>Horseplay actions such as running, diving, head-first entries, continuous jumping, or lifting others higher than waist high in the water are prohibited. </li>
                        <li>Cut offs, color t-shirts, undergarments of any kind, mesh and/or basketball shorts are prohibited in the pool.</li>
                        <li>Floating devices including rafts, beach balls, surfboards, or similar beach equipment are prohibited in the pool. </li>
                        <li>Guests with open wounds, respiratory illnesses, and other conditions that are infectious or communicable are prohibited in the pool. 
                        </li>
                        <li>The use of inappropriate or foul language anywhere within the pool area is prohibited.</li>
                        <li>Swimmers are to circle swim and are limited to 20 minutes when the pool becomes crowded during lap swim hours.</li>
                        <li>All non-swimmers must remain in the shallow area of the pool. </li>
                        <li>Patrons must rinse off equipment after use before returning to storage to ensure the equipment life.</li>
                        <li>Do not talk to guards on duty. All guests must obey the management and lifeguards.</li>
                        <li>In an emergency, contact a lifeguard.</li>
                        <li >When you hear one long continuous whistle, you are to exit the water immediately.</li>
                    </ul>
                </ol>   
            </div>
            <div class="modal-footer">
                <form id="termsAndConditionsForm">
                    <input type="checkbox" id="agreeCheckbox" name="agreeCheckbox">
                    <label for="agreeCheckbox" class="fw-bold italic">I agree to the terms and conditions</label>
                </form>
            </div>
        </div>
    </div>
</div>

