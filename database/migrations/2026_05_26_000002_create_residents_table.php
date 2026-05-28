<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('household_id')->nullable()->constrained('households')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Personal & Basic Info
            $table->string('population_no')->nullable()->index();
            $table->string('family_no')->nullable()->index();
            $table->string('relationship_to_head')->nullable();
            $table->string('is_house_owner')->nullable();
            $table->string('is_renter')->nullable();
            $table->string('renter_months')->nullable();
            $table->string('last_name')->nullable()->index();
            $table->string('first_name')->nullable()->index();
            $table->string('middle_name')->nullable();
            $table->string('extension')->nullable(); // Jr, Sr, etc.
            $table->string('birthdate')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('sex')->nullable(); // Male/Female
            $table->text('gender_identity')->nullable();
            $table->text('civil_status')->nullable();
            $table->string('religion')->nullable();
            $table->string('citizenship')->nullable();
            $table->integer('age')->nullable()->index();
            $table->text('age_classification')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('complexion')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('email_address')->nullable()->index();
            $table->string('social_media_account')->nullable();
            
            // Education & Skills
            $table->text('educational_status')->nullable();
            $table->text('highest_educational_attainment')->nullable();
            $table->string('school_attended')->nullable();
            $table->string('course_completed')->nullable();
            $table->text('eligibility')->nullable();
            $table->string('primary_skills')->nullable();
            $table->string('secondary_skills')->nullable();
            $table->string('other_skills')->nullable();
            
            // Employment & Income
            $table->text('work_status')->nullable();
            $table->string('occupation')->nullable();
            $table->string('is_farmer')->nullable();
            $table->string('income')->nullable();
            $table->string('days_work_per_week')->nullable();
            $table->string('last_period_of_unemployment')->nullable();
            $table->string('reason_of_unemployment')->nullable();
            
            // Voter Info
            $table->string('registered_sk_voter')->nullable();
            $table->string('registered_national_voter')->nullable();
            $table->string('attended_kk_assembly')->nullable();
            $table->string('kk_assembly_times')->nullable();
            $table->string('kk_assembly_no_reason')->nullable();
            $table->string('resident_voter')->nullable();
            $table->string('last_voted_year')->nullable();
            
            // Health & Vaccinations
            $table->string('has_philhealth')->nullable();
            $table->string('philhealth_id')->nullable();
            $table->text('philhealth_membership_type')->nullable();
            $table->string('unvaccinated')->nullable();
            $table->string('partially_vaccinated')->nullable();
            $table->string('fully_vaccinated')->nullable();
            $table->string('covid_dose_1_date')->nullable();
            $table->string('covid_dose_2_date')->nullable();
            $table->string('covid_brand')->nullable();
            $table->string('has_booster')->nullable();
            $table->string('booster_date')->nullable();
            $table->string('booster_brand')->nullable();
            $table->text('health_condition')->nullable();
            $table->text('nutritional_classification')->nullable();
            $table->text('vulnerable_sector')->nullable();
            $table->text('social_welfare_availed')->nullable();
            
            // Water, Toilet & Waste
            $table->text('water_source')->nullable();
            $table->text('sanitary_toilet')->nullable();
            $table->text('waste_management')->nullable();
            $table->string('has_blind_drainage')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
