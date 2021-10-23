<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStorageProcedureSpConsultTopicDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
                    CREATE PROCEDURE sp_acd_consult_topic_details(IN _flag INT, IN course_id BIGINT,IN _search BIGINT)
                    BEGIN
                        IF _flag = 1 THEN
                            SELECT
                                t1.id,
                                t1.title,
                                t1.course_id,
                                t1.state,
                                t1.number,
                                CONCAT('[',(
                                    SELECT
                                        GROUP_CONCAT(JSON_OBJECT('id',t2.id,'title',t2.title,'date_start',t2.date_start,'date_end',t2.date_end,'time_start',t2.time_start,'time_end',t2.time_end,'state',t2.state,'live',t2.live,'number',t2.number,'class_activities',(CONCAT('[',(
                                            SELECT
                                            GROUP_CONCAT(JSON_OBJECT('id',t3.id,'description',t3.description,'body',t3.body,'state',t3.state,'academic_type_activitie_id',t3.academic_type_activitie_id,'academic_type_activitie',academic_type_activities.description,'number',t3.number)) AS class_activiti
                                            FROM class_activities AS t3
                                            INNER JOIN academic_type_activities ON t3.academic_type_activitie_id=academic_type_activities.id
                                            WHERE t3.topic_class_id=t2.id AND t3.deleted_at IS NULL
                                        ),']'
                                        )))) AS topic_classe
                                    FROM topic_classes AS t2
                                    WHERE t2.course_topic_id=t1.id
                                    ),']'
                                ) AS topic_classes
                            FROM course_topics AS t1
                            WHERE t1.course_id = course_id AND teacher_course_id=_search
                            AND t1.deleted_at IS NULL
                            ORDER BY t1.number;
                        END IF;
                        IF _flag = 2 THEN
                            BEGIN
                                DECLARE xlevel BIGINT;
                                DECLARE xyear BIGINT;

                                SELECT academic_level_id,academic_year_id INTO xlevel,xyear FROM courses WHERE id=course_id;

                                IF xlevel IS NULL AND xyear IS NULL THEN
                                    SELECT
                                        t1.id,
                                        t1.title,
                                        t1.course_id,
                                        t1.state,
                                        t1.number,
                                        CONCAT('[',(
                                            SELECT
                                            GROUP_CONCAT(JSON_OBJECT('id',t2.id,'title',t2.title,'date_start',t2.date_start,'date_end',t2.date_end,'time_start',t2.time_start,'time_end',t2.time_end,'state',t2.state,'live',t2.live,'number',t2.number,'class_activities',(CONCAT('[',(
                                                SELECT
                                                GROUP_CONCAT(JSON_OBJECT('id',t3.id,'description',t3.description,'body',t3.body,'state',t3.state,'academic_type_activitie_id',t3.academic_type_activitie_id,'academic_type_activitie',academic_type_activities.description,'number',t3.number)) AS class_activiti
                                                FROM class_activities AS t3
                                                INNER JOIN academic_type_activities ON t3.academic_type_activitie_id=academic_type_activities.id
                                                WHERE t3.topic_class_id=t2.id AND t3.deleted_at IS NULL
                                            ),']'
                                            )))) AS topic_classe
                                            FROM topic_classes AS t2
                                            WHERE t2.course_topic_id=t1.id
                                            ),']'
                                        ) AS topic_classes
                                    FROM course_topics AS t1
                                    INNER JOIN cadastre_courses AS t4 ON t1.course_id=t4.course_id
                                    WHERE t1.course_id = course_id AND t4.cadastre_id=_search
                                    AND t1.deleted_at IS NULL
                                    ORDER BY t1.number;
                                ELSE
                                    SELECT
                                        t1.id,
                                        t1.title,
                                        t1.course_id,
                                        t1.state,
                                        t1.number,
                                        CONCAT('[',(
                                            SELECT
                                            GROUP_CONCAT(JSON_OBJECT('id',t2.id,'title',t2.title,'date_start',t2.date_start,'date_end',t2.date_end,'time_start',t2.time_start,'time_end',t2.time_end,'state',t2.state,'live',t2.live,'number',t2.number,'class_activities',(CONCAT('[',(
                                                SELECT
                                                GROUP_CONCAT(JSON_OBJECT('id',t3.id,'description',t3.description,'body',t3.body,'state',t3.state,'academic_type_activitie_id',t3.academic_type_activitie_id,'academic_type_activitie',academic_type_activities.description,'number',t3.number)) AS class_activiti
                                                FROM class_activities AS t3
                                                INNER JOIN academic_type_activities ON t3.academic_type_activitie_id=academic_type_activities.id
                                                WHERE t3.topic_class_id=t2.id AND t3.deleted_at IS NULL
                                            ),']'
                                            )))) AS topic_classe
                                            FROM topic_classes AS t2
                                            WHERE t2.course_topic_id=t1.id
                                            ),']'
                                        ) AS topic_classes
                                    FROM course_topics AS t1
                                    INNER JOIN cadastres AS t4 ON t1.course_id=t4.course_id
                                    WHERE t1.course_id = course_id AND t4.id=_search
                                    AND t1.deleted_at IS NULL
                                    ORDER BY t1.number;
                                END IF;
                            END;

                        END IF;
                    END
        ";

        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_acd_consult_topic_details");
    }
}
