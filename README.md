# ETSIIT Information - Voice Response Application
This is a VoiceXML (Voice Extensible Markup Language) project that provides information about the Faculty of Computer Science and Telecommunications at the University of Granada. It supports both Spanish and English languages for voice interactions.

## Overview
This VoiceXML application allows users to obtain information about the faculty, including details about different degree programs, professors, courses, and schedules. Users can interact with the application by speaking and following voice prompts.

## Usage
1. **Select Degree Program**: Start by specifying the degree program you are interested in. You can say the name of the degree program you want information about.

2. **Choose Option**: After selecting a degree program, you can choose one of the following options:

* Get information about professors.
* Get information about courses.
* Get information about schedules.
* Start over.
3. **Get Information**:

* If you choose to get information about professors, you can provide the name of the professor you're interested in.
* If you choose to get information about courses, you can provide the name of the course.
* If you choose to get information about schedules, you can provide the name of the course and the group for which you want the schedule.
4. **Results**: The application will provide information based on your input.

## Code Structure
The main code file, `info_[lang].vxml`, defines the entire VoiceXML application. It includes the following components:

* Constants: Definitions of degree program names.
* Variables: Variables used to store user input and other data.
* Prompts: Predefined prompts used during interactions.
* Scripts: JavaScript functions used for validation and data manipulation.
* Grammars: Speech recognition grammars for different language elements.
* Forms: Forms represent different stages of the conversation and handle user input.
## Getting Started
To run this VoiceXML application, you will need a compatible VoiceXML interpreter or platform. You can deploy this application to a web server or a VoiceXML platform that supports VoiceXML 2.1.

Make sure to provide the necessary grammars and endpoints for fetching data according to the `submit` elements in the forms.

## Additional Notes
* Ensure that the required resources such as grammars and scripts are available and properly configured.
* Customize the `submit` elements in each form to point to the appropriate backend services for fetching data.
* Customize error messages and prompts as needed for a more user-friendly experience.
For more information about VoiceXML and the University of Granada's Faculty of Computer Science and Telecommunications, refer to the relevant documentation and resources.

**Note**: This readme assumes that the necessary backend services and endpoints are set up to provide the requested information.
