CREATE OR REPLACE VIEW v_admins AS SELECT
	u.name AS 'Admin',
	a.date AS 'Since',
	p.number AS 'Phone'
		FROM admins a
			JOIN users u ON a.users_id = u.id
			LEFT JOIN phones p ON u.id = p.users_id AND p.is_primary
				WHERE a.active IS TRUE; /* ORDER BY u.name -- on queries*/

CREATE OR REPLACE VIEW v_partners AS SELECT
	u.name AS 'Partner',
	p.date AS 'Since',
	ph.number AS 'Phone'
		FROM partners p
			JOIN users u ON p.users_id = u.id
			LEFT JOIN phones ph ON u.id = ph.users_id AND ph.is_primary
				WHERE p.active IS TRUE; /* ORDER BY u.name */

CREATE OR REPLACE VIEW v_veterinarians AS SELECT
	u.name AS 'Veterinarian',
	v.date AS 'Since',
	p.number AS 'Phone'
		FROM veterinarians v
			JOIN users u ON v.users_id = u.id
			LEFT JOIN phones p ON u.id = p.users_id AND p.is_primary
				WHERE v.active IS TRUE; /* ORDER BY u.name */

CREATE OR REPLACE VIEW v_veterinarian_schedules AS SELECT
	u.name AS 'Veterinarian',
	p.number AS 'Phone',
	sw.date AS 'Day',
	s.hour_start AS 'Shift starts at',
	s.hour_end AS 'Shift ends at'
		FROM veterinarians v
			JOIN users u ON v.users_id = u.id
			JOIN shifts_workers sw ON v.id = sw.veterinarians_id
			JOIN shifts s ON sw.shifts_id = s.id
			LEFT JOIN phones p ON u.id = p.users_id AND p.is_primary
				 WHERE v.active IS TRUE AND sw.date >= CURRENT_DATE; /* ORDER BY sw.date, s.hour_start, s.hour_end, u.name */

CREATE OR REPLACE VIEW v_volunteers AS SELECT
	u.name AS 'Volunteer',
	v.date AS 'Since',
	p.number AS 'Phone'
		FROM volunteers v
			JOIN users u ON v.users_id = u.id
			LEFT JOIN phones p ON u.id = p.users_id AND p.is_primary
				WHERE v.active IS TRUE; /* ORDER BY u.name */

CREATE OR REPLACE VIEW v_volunteer_schedules AS SELECT
	u.name AS 'Volunteer',
	p.number AS 'Phone',
	sw.date AS 'Day',
	s.hour_start AS 'Shift starts at',
	s.hour_end AS 'Shift ends at'
		FROM volunteers v
			JOIN users u ON v.users_id = u.id
			JOIN shifts_workers sw ON v.id = sw.volunteers_id
			JOIN shifts s ON sw.shifts_id = s.id
			LEFT JOIN phones p ON u.id = p.users_id AND p.is_primary
				 WHERE v.active IS TRUE AND sw.date >= CURRENT_DATE; /* ORDER BY sw.date, s.hour_start, s.hour_end, u.name */

CREATE OR REPLACE VIEW v_event_organizers AS SELECT
	u.name AS 'Organizer',
	p.number AS 'Phone',
	ev.role AS 'Role',
	e.name AS 'Event',
	e.date_start AS 'Starting at',
	e.date_end AS 'Ending at'
		FROM volunteers v
			JOIN users u ON v.users_id = u.id
			JOIN events_volunteers ev ON v.id = ev.volunteers_id
			JOIN events e ON ev.events_id = e.id
			LEFT JOIN phones p ON u.id = p.users_id AND p.is_primary
				WHERE v.active IS TRUE AND e.date_end >= CURRENT_TIMESTAMP; /* ORDER BY e.date_start, e.date_end, e.name, ev.role, u.name */

CREATE OR REPLACE VIEW v_events AS SELECT
	e.name AS 'Event',
	e.date_start AS 'Starting at',
	e.date_end AS 'Ending at',
	COUNT(p.id) AS 'Participants',
	COUNT(p.animals_id) AS 'Bringing animals'
		FROM events e
			JOIN participants p ON e.id = p.events_id
				WHERE e.date_end >= CURRENT_TIMESTAMP; /* ORDER BY e.date_start, e.date_end, e.name */

CREATE OR REPLACE VIEW v_event_participants AS SELECT
	e.name AS 'Event',
	u.name AS 'Participant',
	u.email AS 'Email',
	a.name AS 'Pet',
	e.date_start AS 'Starts at',
	e.date_end AS 'Ends at'
		FROM participants p
			JOIN users u ON p.users_id = u.id
			JOIN events e ON p.events_id = e.id
			LEFT JOIN animals a ON p.animals_id = a.id
				WHERE e.date_end >= CURRENT_TIMESTAMP; /* ORDER BY e.date_start, e.date_end, u.name -- Maybe could even add u.disabled but it's possible that blocked users show to events? */

CREATE OR REPLACE VIEW v_donor AS SELECT
	u.name AS 'Donor',
	u.email AS 'Email',
	p.number AS 'Phone',
	COUNT(d.id) AS 'Times donated',
	Sum(d.amount) AS 'Total donated' -- Maybe add first and last time donated?
		FROM users u
			JOIN donations d ON u.id = d.users_id
			LEFT JOIN phones p ON u.id = p.users_id AND p.is_primary
				WHERE u.disabled IS FALSE
					GROUP BY u.id;

CREATE OR REPLACE VIEW v_donations AS SELECT
	COALESCE(u.name, d.name) AS 'Donor',
	u.email AS 'Email',
	p.number AS 'Phone',
	d.amount AS 'Amount',
	d.notes AS 'Details',
	d.date AS 'Date'
		FROM donations d
			LEFT JOIN users u ON d.users_id = u.id
			LEFT JOIN phones p ON u.id = p.users_id AND p.is_primary; /* ORDER BY d.amount, d.date DESC, u.name */

CREATE OR REPLACE VIEW v_candidates AS SELECT
	u.name AS 'Candidate',
	a.position AS 'Position',
	TIMESTAMPDIFF(YEAR, u.birthday, CURDATE()) AS 'Age',
	u.gender AS 'Gender',
	a.cv AS 'Curriculum',
	u.email AS 'Email',
	p.number AS 'Phone',
	a.notes AS 'Details',
	a.date AS 'Applied at'
		FROM applications a
			JOIN users u ON a.users_id = u.id
			LEFT JOIN phones p ON u.id = p.users_id AND p.is_primary; /* ORDER BY a.position, u.name -- Maybe WHERE u.disabled = FALSE? -- Maybe also age > 18 */

CREATE OR REPLACE VIEW v_missing AS SELECT

CREATE OR REPLACE VIEW v_animals AS SELECT

CREATE OR REPLACE VIEW v_participants AS SELECT

CREATE OR REPLACE VIEW v_adoptions AS SELECT -- ?

CREATE OR REPLACE VIEW v_adopters AS SELECT

CREATE OR REPLACE VIEW v_vaccinations AS SELECT

CREATE OR REPLACE VIEW v_checkups AS SELECT
	u_c.name AS 'Client',
	uc_p.number AS 'Clients Phone',
	a.name AS 'Pet',
	c.type AS 'Type',
	c.date AS 'Date',
	c.status AS 'Status',
	u_v.name AS 'Veterinarian',
	uv_p.number AS 'Veterinarians Phone',
	c.results AS 'Results'
		FROM checkups c
			JOIN users u_c ON c.users_id = u_c.id
			LEFT JOIN phones uc_p ON u_c.id = uc_p.users_id AND uc_p.is_primary
			JOIN veterinarians v ON c.veterinarians_id = v.id
			JOIN users u_v ON v.users_id = u_v.id
			LEFT JOIN phones uv_p ON u_v.id = uv_p.users_id AND uv_p.is_primary
			JOIN animals a ON c.animals_id = a.id
				WHERE c.date >= CURRENT_TIMESTAMP;

CREATE OR REPLACE VIEW v_users AS SELECT
	u.name AS 'Name',
	u.email AS 'Email',
	p.number AS 'Phone',
	CONCAT(a.country, ', ', a.city, ', ', a.street, ', ', a.number, ', ', a.zip) AS 'Address',
	TIMESTAMPDIFF(YEAR, u.birthday, CURDATE()) AS 'Age',
	u.gender AS 'Gender',
	u.nif AS 'NIF',
	u.notes AS 'Details',
	u.date AS 'Created at'
		FROM users u
			LEFT JOIN phones p ON u.id = p.users_id
			LEFT JOIN addresses a ON u.id = a.users_id
				WHERE u.disabled IS FALSE; /* ORDER BY u.name */

CREATE OR REPLACE VIEW v_default_users AS SELECT
	u.name AS 'Default user',
	u.date AS 'Since',
	u.email AS 'Email'
		FROM users u
			LEFT JOIN admins a ON u.id = a.users_id
			LEFT JOIN partners p ON u.id = p.users_id
			LEFT JOIN veterinarians ve ON u.id = ve.users_id
			LEFT JOIN volunteers vo ON u.id = vo.users_id
			LEFT JOIN participants pa ON u.id = pa.users_id
			LEFT JOIN donations d ON u.id = d.users_id
			LEFT JOIN applications ap ON u.id = ap.users_id
			LEFT JOIN animals an ON u.id = an.users_id
			LEFT JOIN adoptions ad ON u.id = ad.users_id
				WHERE u.disabled IS FALSE AND(
					a.users_id IS NULL
					OR p.users_id IS NULL
					OR ve.users_id IS NULL
					OR vo.users_id IS NULL
					OR pa.users_id IS NULL
					OR d.users_id IS NULL
					OR ap.users_id IS NULL
					OR an.users_id IS NULL
					OR ad.users_id IS NULL
				); /* ORDER BY u.name */

CREATE OR REPLACE VIEW v_users_verify AS SELECT
	u.id AS 'User ID',
	u.name AS 'Name',
	u.disabled AS 'Account disabled',
	vo.active AS 'Active as Volunteer',
	ve.active AS 'Active as Veterinarian',
	p.active AS 'Active as Partner',
	a.active AS 'Active as Admin'
		FROM users u
			LEFT JOIN admins a ON u.id = a.users_id
			LEFT JOIN partners p ON u.id = p.users_id
			LEFT JOIN veterinarians ve ON u.id = ve.users_id
			LEFT JOIN volunteers vo ON u.id = vo.users_id
				WHERE u.disabled IS TRUE AND(
					u.id = a.users_id
					OR u.id = p.users_id
					OR u.id = ve.users_id
					OR u.id = vo.users_id
				); /* ORDER BY u.name -- Maybe include adoption processess, missing animals, adoptions, etc */

-- Fix phone & addresses being required and update EER with views -- Add is_primary to addresses, not necessary