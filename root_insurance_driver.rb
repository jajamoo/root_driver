class Driver
	attr_accessor :total_distance, :total_time, :name
	@@drivers = []

	def initialize (name)
		@name = name
		@total_distance = 0
		@total_time = 0
		@@drivers << self
	end

	def self.calculate_trip(name, start_time, end_time, drive_miles)
		@@drivers.each do |driver|
			if driver.name === name
			    #Divide by 3600 because we're going from seconds --> hours
				time_taken = (Time.new(2021,1,1,end_time.split(':')[0],end_time.split(':')[1])-Time.new(2021,1,1,start_time.split(':')[0],start_time.split(':')[1]))/3600
				speed = drive_miles/time_taken
				if ((speed < 100) && (speed > 5))
					driver.total_time += time_taken
					driver.total_distance += drive_miles
				end
			end
		end
	end

    def self.show_the_trips
        @@drivers.sort_by! {|driver| driver.total_distance}.reverse!
        @@drivers.each do |driver|
            if driver.total_time == 0
                puts "#{driver.name}: #{driver.total_distance.round} miles @ 0 mph"
            else
                mph = driver.total_distance/driver.total_time
                puts "#{driver.name}: #{driver.total_distance.round} miles @ #{mph.round} mph"
            end
        end
    end
end

input_file = ARGV[0]
File.open(input_file).readlines.each do |line|
	if line.split[0] === "Driver"
		Driver.new(line.split[1])
	elsif line.split[0] === "Trip"
		Driver.calculate_trip(line.split[1],line.split[2],line.split[3],line.split[4].to_f)
	end
end

#print the trips out
Driver.show_the_trips
